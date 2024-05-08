<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Capacidades;
use App\Models\preguntas;
use App\Models\RecomendacionPorDimensionModel;
use App\Models\RespuestasPreguntas;
use App\Models\RespuestasUsuarios;
use App\Models\Dimensiones;
use App\Models\UsuariosConsultoria;
use PDF;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Shape\Chart\Gridlines;
use PhpOffice\PhpPresentation\Shape\Chart\Marker;
use PhpOffice\PhpPresentation\Shape\Chart\Series;
use PhpOffice\PhpPresentation\Shape\Chart\Type\Radar;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Style\Color as StyleColor;
use PhpOffice\PhpPresentation\Slide\Background\Color;
use PhpOffice\PhpPresentation\Shape\RichText\Paragraph;
use Illuminate\Http\Request;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Shape\Drawing;
use PhpOffice\PhpPresentation\Style\Fill;


class GenerarReporteController extends Controller
{

    const TEXT_COLOR = 'ff545454';
    public function generarReporte($idUsuario)
    {

        $respuestasUsuarios = $this->obtenerPreguntasConRecomendacion($idUsuario);
        $usuario = UsuariosConsultoria::where('usuarioConsultoriaId', $idUsuario)->first();
        foreach ($respuestasUsuarios as $respuestaUsuario) {
            $respuesta = RespuestasPreguntas::where('respuestaId', $respuestaUsuario->respuestaFk)->first();
            $pregunta = preguntas::where('preguntaId', $respuesta->preguntaFk)->first();
            $capacidad = Capacidades::where('capacidadId', $pregunta->capacidadFk)->first();
            $dimension = Dimensiones::where('dimensionId', $capacidad->dimensionFk)->first();
            $recomendacion = RecomendacionPorDimensionModel::where('usuarioFk', $idUsuario)->where('dimensionFk', $dimension->dimensionId)->first();
            $consolidado['data'][$dimension->nombre][$capacidad->nombre] = [
                'dimension' => $dimension->nombre,
                'capacidad' => $capacidad->nombre,
                'descripcion_capacidad' => $capacidad->descripcion,
                'pregunta' => $pregunta->texto,
                'respuesta' => $respuesta->texto,
                'recomendacion' => $respuestaUsuario->recomendacion_copilot,
                'valor'=> $respuesta->peso,
                'clasificacion' => $respuesta->clasificacion,

            ];


            $consolidado['data'][$dimension->nombre]['recomendacion'] =   json_decode(str_replace( '*','',$recomendacion->recomendacion_copilot,));
            $consolidado['data'][$dimension->nombre]['promt'] = $recomendacion->promt;
            $consolidado['data'][$dimension->nombre]['nombre'] = $dimension->nombre;

        }

        foreach ($consolidado['data'] as $key => $dimension) {
            $acum = 0;
            $contador = 0;
            foreach ($dimension as $key2 => $capacidad) {
                    if($key2 == 'recomendacion' || $key2 == 'promt' || $key2 == 'nombre') {
                        continue;
                    } else {
                        $acum += $capacidad['valor'];
                        $contador++;
                    }
                 }
            $consolidado['data'][$key]['promedio'] = $acum / $contador;
            $consolidado['data'][$key]['Clasificacion'] = $this->obtenerClasificacion($consolidado['data'][$key]['promedio']);
        }

       foreach ($consolidado['data'] as $key => $dimension){
            if($key == 'graficos') {
                continue;
            } else{
                $consolidado['data']['graficos'][$key] =$dimension['promedio'];
//                $consolidado['data']['graficos']['valores'] .= . ",";
            }
        }

//        $consolidado['data']['graficos']['dimensiones'] = substr($consolidado['data']['graficos']['dimensiones'], 0, -1);
//        $consolidado['data']['graficos']['valores'] = substr($consolidado['data']['graficos']['valores'], 0, -1);
        $consolidado['data']['resumenes']['resumen_ejecutivo'] =  str_replace( '*','',$usuario->resumen_ejecutivo);



//----- esto es para crear en pdf en la vista fea
//        $pdf = PDF::loadView('myPDF', $consolidado);
//        return view('myPDF', $consolidado);
//        return $pdf->download($usuario->nombre_inmobiliaria . '.pdf');


        // Creamos la presentacion.
        $presentation = new PhpPresentation();
        $presentation->getLayout()->setDocumentLayout(['cx' => 1920, 'cy' => 1080], true)
            ->setCX(1920, DocumentLayout::UNIT_PIXEL)
            ->setCY(1080, DocumentLayout::UNIT_PIXEL);
        $titleSlide = $presentation->getActiveSlide();
        // damos color de fondo a la diapositiva de titulo
        $titleSlide = $this->setTitleBackgroundColor($titleSlide);
        //Creamos la diapositiva de titulo #1
        $titleSlide = $this->createTitleSlide1($titleSlide,$usuario);
        //Creamos la diapositiva #2
        $diapositiva2 = $presentation->createSlide();
        // Seteamos el contenido de la diapositiva 2
        $diapositiva2 = $this->createContentSlide2($diapositiva2);
        // creamos la diapositiva 3
        $diapositiva3 = $presentation->createSlide();
        // Seteamos el contenido de la diapositiva 3
        $diapositiva3 = $this->createDiapositiva3($diapositiva3);
        // creamos la diapositiva 4
        $diapositiva4 = $presentation->createSlide();
        // damos fondo a de titulo a la diapositiva 4
        $diapositiva4 = $this->setTitleBackgroundColor($diapositiva4);
        // Seteamos el contenido de la diapositiva 4
        $diapositiva4 = $this->createDiapositiva4($diapositiva4);
        // creamos la diapositiva 5
        $diapositiva5 = $presentation->createSlide();
        // Seteamos el contenido de la diapositiva 5
        $diapositiva5 = $this->createDiapositiva5($diapositiva5, str_replace( '*','',$usuario->resumen_ejecutivo), $consolidado['data']['graficos']);
        // Creamos la diapositiva 6
        $diapositiva6 = $presentation->createSlide();
        // damos fondo a de titulo a la diapositiva 6
        $diapositiva6 = $this->setTitleBackgroundColor($diapositiva6);
        // Seteamos el contenido de la diapositiva 6
        $diapositiva6 = $this->createDiapositiva6($diapositiva6);
        //Creamos diapositiva 7
        $diapositiva7 = $presentation->createSlide();
        // Seteamos el contenido de la diapositiva 7
        $diapositiva7 = $this->createDiapositiva7($diapositiva7, 'Aca va el analisis del comparativo de cifras con el sector', $consolidado['data']['graficos']);
        // Creamos la diapositiva 8
        $diapositiva8 = $presentation->createSlide();
        // damos fondo a de titulo a la diapositiva 8
        $diapositiva8 = $this->setTitleBackgroundColor($diapositiva8);
        // Seteamos el contenido de la diapositiva 8
        $diapositiva8 = $this->createDiapositiva8($diapositiva8);
       // aca se debe crear el ciclo para crear todas las diapositivas de las dimensiones
        foreach ($consolidado['data'] as $key => $dimension){
            if($key == 'graficos' || $key == 'resumenes' ) {
                continue;
            } else {

                $diapositiva = $presentation->createSlide();
                $diapositiva = $this->setTitleBackgroundColor($diapositiva, $key);
                $diapositiva = $this->createDiapositiva9($diapositiva, $key);
                $recomendacionSlide = $presentation->createSlide();
                $recomendacionSlide = $this->createDiapositivaRecomendaciones($recomendacionSlide, $dimension);
            }
        }

        $writer = IOFactory::createWriter($presentation, 'PowerPoint2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
        header('Content-Disposition: attachment; filename="'. urlencode($usuario->nombre_inmobiliaria.'.pptx').'"');
        return $writer->save('php://output');



    }


    private function obtenerPreguntasConRecomendacion($id_usuario)
    {
        $respuestasUsuariosSinRecomentacion = RespuestasUsuarios::Where('usuarioFk', $id_usuario)->whereNotNull('recomendacion_copilot')->get();


        return $respuestasUsuariosSinRecomentacion;
    }

    private function obtenerClasificacion($valor)
    {
        if($valor >= 1 && $valor <= 1.9) {
            return 'Crawl';
        } else if($valor >=2 && $valor <= 2.9) {
            return 'Walk';
        } else {
            return 'Run';
        }
    }

    private function setTitleBackgroundColor($slide){
        $backgroundColor = new Color();
        $backgroundColor->setColor(new StyleColor('ff000738'));
        $slide->setBackground($backgroundColor);
        return $slide;
    }

    private function createTitleSlide1($titleSlide,$usuario){
        //Creamos el titulo
        $shapeTitle = $titleSlide->createRichTextShape()
            ->setHeight(174)
            ->setWidth(1423)
            ->setOffsetX(105)
            ->setOffsetY(165);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRun = $shapeTitle->createTextRun('TRANSFORMACIÓN  DIGITAL');
        $textRun->getFont()->setBold(true)->setSize(128)->setColor(new StyleColor(StyleColor::COLOR_WHITE));

        //creamos el parrafo del titulo
        $shapeParagraph = $titleSlide->createRichTextShape()
            ->setHeight(52)
            ->setWidth(1429)
            ->setOffsetX(105)
            ->setOffsetY(584);
        $shapeParagraph->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRunparagraph = $shapeParagraph->createTextRun('Valoración de capacidades de transformación digital de la empresa');
        $textRunparagraph->getFont()->setBold(false)->setSize(36)->setColor(new StyleColor(StyleColor::COLOR_WHITE));

        //creamos el parrafo del Nombre de la empresa
        $shapeEnterprise = $titleSlide->createRichTextShape()
            ->setHeight(52)
            ->setWidth(1129)
            ->setOffsetX(105)
            ->setOffsetY(630);
        $shapeEnterprise->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRunEnterprise = $shapeEnterprise->createTextRun($usuario->nombre_inmobiliaria);
        $textRunEnterprise->getFont()->setBold(true)->setSize(36)->setColor(new StyleColor(StyleColor::COLOR_WHITE));


        // Creamos la imagen del logo de Jadi SAS

        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterTitulos.png')
            ->setOffsetX(105)
            ->setOffsetY(847)
            ->setWidthAndHeight(240,117)
            ->setResizeProportional(true);

        $titleSlide->addShape($shapelogo);
        return $titleSlide;
    }

    private function createContentSlide2($diapositiva2){
        // Creamos barra de titulo y texto
        $shapeTitleBlue = new Drawing\File();
        $shapeTitleBlue->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/backgroundTittleBlue2.png')
            ->setWidthAndHeight(881,60)
            ->setResizeProportional(true)
            ->setOffsetX(0)
            ->setOffsetY(63);
        //agregamos texto dentro de la forma
        $diapositiva2->addShape($shapeTitleBlue);
        $shapeTitle = $diapositiva2->createRichTextShape()
            ->setWidthAndHeight(759,33)
            ->setOffsetX(74)
            ->setOffsetY(60);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_CENTER);
        $textRun = $shapeTitle->createTextRun('Diagnóstico de madurez digital - Modelo DiGiPT');
        $textRun->getFont()->setBold(false)->setSize(32)->setColor(new StyleColor(StyleColor::COLOR_WHITE));
        //creamos el parrafo del titulo
        $parrafoTitulo = "Bienvenidos al DigiPT Model, una encuesta diseñada para ofrecer a su organización una visión clara de su estado actual en ocho dimensiones críticas para el éxito en la era digital. A través de este modelo, exploraremos su Estrategia Digital, Tecnología y Arquitectura, Innovación, Agilidad Organizacional, Analítica y Datos, Operaciones y Procesos, Personas y Cultura, y Experiencia del Cliente.

Nuestro objetivo es proporcionar un diagnóstico detallado que sirva como punto de partida para el fortalecimiento y la transformación de su empresa. Al finalizar, obtendrán insights valiosos que resaltarán oportunidades de mejora y consolidarán sus puntos fuertes. Participar en este diagnóstico es dar un paso adelante hacia la optimización de su enfoque estratégico y operativo, asegurando que cada aspecto de su negocio esté alineado y sea capaz de responder con dinamismo a los retos del mercado actual.";
        $shapeParagraph = $diapositiva2->createRichTextShape()
            ->setHeight(460)
            ->setWidth(1550)
            ->setOffsetX(74)
            ->setOffsetY(230);
        $shapeParagraph->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_JUSTIFY);
        $textRunparagraph = $shapeParagraph->createTextRun($parrafoTitulo);
        $textRunparagraph->getFont()->setBold(false)->setSize(32)->setColor(new StyleColor(self::TEXT_COLOR));

        // Creamos la imagen del logo de Jadi SAS
        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterDiapositivaBlanca.png')
            ->setOffsetX(1690)
            ->setOffsetY(930)
            ->setWidthAndHeight(155,77)
            ->setResizeProportional(true);

        $diapositiva2->addShape($shapelogo);

        return $diapositiva2;
    }

    private function createDiapositiva3($diapositiva3){
        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/diapositiva3.png')
            ->setOffsetX(80)
            ->setOffsetY(80)
            ->setWidthAndHeight(1760,920)
            ->setResizeProportional(true);

        $diapositiva3->addShape($shapelogo);

        return $diapositiva3;
    }

    private function createDiapositiva4($diapositiva4){
        //Creamos el titulo
        $shapeTitle = $diapositiva4->createRichTextShape()
            ->setHeight(174)
            ->setWidth(800)
            ->setOffsetX(105)
            ->setOffsetY(165);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $text = 'RESUMEN EJECUTIVO';
        $textRun = $shapeTitle->createTextRun($text);
        $textRun->getFont()->setBold(true)->setSize(128)->setColor(new StyleColor(StyleColor::COLOR_WHITE));
         // Creamos la imagen del logo de Jadi SAS

        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterTitulos.png')
            ->setOffsetX(105)
            ->setOffsetY(847)
            ->setWidthAndHeight(240,117)
            ->setResizeProportional(true);

        $diapositiva4->addShape($shapelogo);
        return $diapositiva4;
    }

    private function createDiapositiva5($diapositiva5,$parrafoTitulo,$dataGraficos){

        // Creamos shape para el grafico
        $radarChart = new Radar();
        $series = new Series('Valoración', $dataGraficos);
        $gridlines = new Gridlines();
        $gridlines->getOutline()->setWidth(1);
        $gridlines->getOutline()->getFill()->setFillType(Fill::FILL_SOLID)->setStartColor(new StyleColor(self::TEXT_COLOR));
        $series->setShowValue(false);
        $series->setShowSeriesName(false);
        $series->setShowLeaderLines(true);
        $series->hasShowLeaderLines(true);
        $series->hasShowSeparator(true);
        $marker = $series->getMarker();
        $marker->setSymbol(Marker::SYMBOL_DASH)->setSize(4);
        $marker->getFill()->setFillType(Fill::FILL_SOLID);

        $radarChart->addSeries($series);
        $shapeChart = $diapositiva5->createChartShape();
        $shapeChart->setName('Grafico')
            ->setResizeProportional(true)
            ->setHeight(600)
            ->setWidth(800)
            ->setOffsetX(105)
            ->setOffsetY(200);
        $shapeChart->getTitle()->setText('Resultado de la valoración de las dimensiones');
        $shapeChart->getPlotArea()->getAxisY()->setMinorUnit(1);
        $shapeChart->getPlotArea()->getAxisY()->setMajorUnit(3);
        $shapeChart->getPlotArea()->getAxisX()->setMajorGridlines($gridlines);
        $shapeChart->getPlotArea()->getAxisY()->setMajorGridlines($gridlines);
        $shapeChart->getPlotArea()->getAxisY()->setMinorGridlines($gridlines);
        $shapeChart->getPlotArea()->getAxisx()->setMinorGridlines($gridlines);
//        $shapeChart->getPlotArea()->getAxisx()->set($gridlines);

        $shapeChart->getPlotArea()->setType($radarChart);

        // Creamos barra de titulo y texto
        $shapeTitleBlue = new Drawing\File();
        $shapeTitleBlue->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/titleGreen.png')
            ->setWidthAndHeight(430,60)
            ->setResizeProportional(true)
            ->setOffsetX(0)
            ->setOffsetY(61);
        //agregamos texto dentro de la forma
        $diapositiva5->addShape($shapeTitleBlue);
        $shapeTitle = $diapositiva5->createRichTextShape()
            ->setWidthAndHeight(307,38)
            ->setOffsetX(34)
            ->setOffsetY(60);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRun = $shapeTitle->createTextRun('Resumen Ejecutivo');
        $textRun->getFont()->setBold(false)->setSize(32)->setColor(new StyleColor(StyleColor::COLOR_WHITE));

        $shapeParagraph = $diapositiva5->createRichTextShape()
            ->setHeight(700)
            ->setWidth(900)
            ->setOffsetX(960)
            ->setOffsetY(60);
        $shapeParagraph->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_JUSTIFY);
        $textRunparagraph = $shapeParagraph->createTextRun($parrafoTitulo);
        $textRunparagraph->getFont()->setBold(false)->setSize(20)->setColor(new StyleColor(self::TEXT_COLOR));

        // Creamos la imagen del logo de Jadi SAS
        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterDiapositivaBlanca.png')
            ->setOffsetX(48)
            ->setOffsetY(946)
            ->setWidthAndHeight(155,77)
            ->setResizeProportional(true);

        $diapositiva5->addShape($shapelogo);

        return $diapositiva5;
    }

    private function createDiapositiva6($diapositiva6)
    {
        //Creamos el titulo
        $shapeTitle = $diapositiva6->createRichTextShape()
            ->setHeight(174)
            ->setWidth(1300)
            ->setOffsetX(105)
            ->setOffsetY(165);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $text = 'COMPARATIVO CON EL SECTOR';
        $textRun = $shapeTitle->createTextRun($text);
        $textRun->getFont()->setBold(true)->setSize(128)->setColor(new StyleColor(StyleColor::COLOR_WHITE));
        // Creamos la imagen del logo de Jadi SAS

        $shapelogo = new Drawing\File();
        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterTitulos.png')
            ->setOffsetX(105)
            ->setOffsetY(847)
            ->setWidthAndHeight(240,117)
            ->setResizeProportional(true);
        $diapositiva6->addShape($shapelogo);
        return $diapositiva6;
    }

    private function createDiapositiva7($diapositiva7,$parrafoTitulo,$dataGraficos){

        // Creamos shape para el grafico
        $radarChart = new Radar();
        $series = new Series('Valoración', $dataGraficos);
        $series->setShowValue(false);
        $series->setShowSeriesName(false);
        $series->hasShowLeaderLines(true);
        $radarChart->addSeries($series);
        $shapeChart = $diapositiva7->createChartShape();
        $shapeChart->setName('Grafico')
            ->setResizeProportional(true)
            ->setHeight(600)
            ->setWidth(800)
            ->setOffsetX(105)
            ->setOffsetY(200);
        $shapeChart->getTitle()->setText('Comparativo con el sector');
        $shapeChart->getPlotArea()->getAxisY()->setMinorUnit(1);
        $shapeChart->getPlotArea()->getAxisY()->setMajorUnit(3);
        $shapeChart->getPlotArea()->setType($radarChart);

        // Creamos barra de titulo y texto
        $shapeTitleBlue = new Drawing\File();
        $shapeTitleBlue->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/backgroundTittleBlue2.png')
            ->setWidthAndHeight(538,80)
            ->setResizeProportional(true)
            ->setOffsetX(0)
            ->setOffsetY(61);
        //agregamos texto dentro de la forma
        $diapositiva7->addShape($shapeTitleBlue);
        $shapeTitle = $diapositiva7->createRichTextShape()
            ->setWidthAndHeight(500,38)
            ->setOffsetX(20)
            ->setOffsetY(50);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRun = $shapeTitle->createTextRun('Comparativo con el sector ');
        $textRun->getFont()->setBold(false)->setSize(28)->setColor(new StyleColor(StyleColor::COLOR_WHITE));

        $shapeParagraph = $diapositiva7->createRichTextShape()
            ->setHeight(700)
            ->setWidth(900)
            ->setOffsetX(960)
            ->setOffsetY(121);
        $shapeParagraph->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_JUSTIFY);
        $textRunparagraph = $shapeParagraph->createTextRun($parrafoTitulo);
        $textRunparagraph->getFont()->setBold(false)->setSize(24)->setColor(new StyleColor(self::TEXT_COLOR));

        // Creamos la imagen del logo de Jadi SAS
        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterDiapositivaBlanca.png')
            ->setOffsetX(48)
            ->setOffsetY(946)
            ->setWidthAndHeight(155,77)
            ->setResizeProportional(true);

        $diapositiva7->addShape($shapelogo);

        return $diapositiva7;
    }

    private function createDiapositiva8($titleSlide){
        //Creamos el titulo
        $shapeTitle = $titleSlide->createRichTextShape()
            ->setHeight(174)
            ->setWidth(1423)
            ->setOffsetX(105)
            ->setOffsetY(165);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRun = $shapeTitle->createTextRun('DIMENSIONES');
        $textRun->getFont()->setBold(true)->setSize(128)->setColor(new StyleColor(StyleColor::COLOR_WHITE));



        // Creamos la imagen del logo de Jadi SAS

        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterTitulos.png')
            ->setOffsetX(105)
            ->setOffsetY(847)
            ->setWidthAndHeight(240,117)
            ->setResizeProportional(true);

        $titleSlide->addShape($shapelogo);
        return $titleSlide;
    }

    private function createDiapositiva9($titleSlide,$dimension)
    {
        //Creamos el titulo
        $shapeTitle = $titleSlide->createRichTextShape()
            ->setHeight(174)
            ->setWidth(1423)
            ->setOffsetX(105)
            ->setOffsetY(165);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRun = $shapeTitle->createTextRun('DIMENSION: '.$dimension);
        $textRun->getFont()->setBold(true)->setSize(128)->setColor(new StyleColor(StyleColor::COLOR_WHITE));



        // Creamos la imagen del logo de Jadi SAS

        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterTitulos.png')
            ->setOffsetX(105)
            ->setOffsetY(847)
            ->setWidthAndHeight(240,117)
            ->setResizeProportional(true);

        $titleSlide->addShape($shapelogo);
        return $titleSlide;
    }

    private function createDiapositivaRecomendaciones($recomendacionSlide, $dimension){
//        dd($dimension);
        // Creamos la imagen de clasificacion

        $shapeClasificacion = new Drawing\File();
        $shapeClasificacion->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/'.$dimension['Clasificacion'].'.png')
            ->setOffsetX(1700)
            ->setOffsetY(870)
            ->setWidthAndHeight(155,200)
            ->setResizeProportional(true);

        $recomendacionSlide->addShape($shapeClasificacion);
        // Creamos barra de titulo y texto
        $shapeTitleBlue = new Drawing\File();
        $shapeTitleBlue->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/backgroundTittleBlue2.png')
            ->setWidthAndHeight(800,80)
            ->setResizeProportional(true)
            ->setOffsetX(0)
            ->setOffsetY(61);
        //agregamos texto dentro de la forma
        $recomendacionSlide->addShape($shapeTitleBlue);
        $shapeTitle = $recomendacionSlide->createRichTextShape()
            ->setWidthAndHeight(800,40)
            ->setOffsetX(20)
            ->setOffsetY(55);
        $shapeTitle->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRun = $shapeTitle->createTextRun('Dimensión '.$dimension['nombre']);
        $textRun->getFont()->setBold(false)->setSize(28)->setColor(new StyleColor(StyleColor::COLOR_WHITE));

        $shapeParagraph = $recomendacionSlide->createRichTextShape()
            ->setHeight(450)
            ->setWidth(1860)
            ->setOffsetX(20)
            ->setOffsetY(140);
        $shapeParagraph->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);
        $textRunparagraph = $shapeParagraph->createTextRun($dimension['recomendacion']->ParrafoDimension);
        $textRunparagraph->getFont()->setBold(false)->setSize(22)->setColor(new StyleColor(self::TEXT_COLOR));

//        $shapeParagraph->getActiveParagraph()->setLineSpacing(300);
        $shapeParagraph->createBreak();

        $shapteTitleRecomendaciones = $recomendacionSlide->createRichTextShape()
            ->setHeight(450)
            ->setWidth(1860)
            ->setOffsetX(20)
            ->setOffsetY(380);

        $textRunTitleRecomendaciones = $shapteTitleRecomendaciones->createParagraph()->createTextRun('Recomendaciones:');
        $textRunTitleRecomendaciones->getFont()->setBold(true)->setSize(24)->setColor(new StyleColor(self::TEXT_COLOR));
        $shapteTitleRecomendaciones->createBreak();
        $shapeRecomendaciones = $recomendacionSlide->createRichTextShape()
            ->setHeight(450)
            ->setWidth(1860)
            ->setOffsetX(20)
            ->setOffsetY(480);
        $shapeRecomendaciones->getActiveParagraph()->getAlignment()->setHorizontal(\PhpOffice\PhpPresentation\Style\Alignment::HORIZONTAL_LEFT);

        $shapeRecomendaciones->getActiveParagraph()->getBulletStyle()->setBulletType(Bullet::TYPE_NUMERIC)->setBulletColor(new StyleColor('ff000738'));

        foreach ($dimension['recomendacion']->Recomendaciones as $recomendacion){
            $textRunRecomendacion = $shapeRecomendaciones->createParagraph()->createTextRun($recomendacion);
            $textRunRecomendacion->getFont()->setBold(false)->setSize(18)->setColor(new StyleColor(self::TEXT_COLOR));
        }
        // Creamos la imagen del logo de Jadi SAS
        $shapelogo = new Drawing\File();
        $shapelogo->setName('Image File')
            ->setDescription('Image File')
            ->setPath(resource_path() .'/reportImages/logoFooterDiapositivaBlanca.png')
            ->setOffsetX(48)
            ->setOffsetY(946)
            ->setWidthAndHeight(155,77)
            ->setResizeProportional(true);

        $recomendacionSlide->addShape($shapelogo);

        return $recomendacionSlide;
    }
}
