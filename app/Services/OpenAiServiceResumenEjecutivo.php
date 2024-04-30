<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;
use Orhanerday\OpenAi\OpenAi;

class OpenAiServiceResumenEjecutivo
{
    protected $apiKey;
    protected $baseUrlTheads = 'https://api.openai.com/v1/threads';

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->assistantId = 'asst_6v31EMaxy22uiG9Gu2U8Ovww';

    }

    public function generateText($promt)
    {
        $open_ai_key = $this->apiKey;
        $open_ai = new OpenAi($open_ai_key);
        $data = [
            'assistant_id' =>  $this->assistantId,
            'thread' => [
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $promt,
                        'file_ids' => [],
                    ],
                ],
            ],
        ];

        $run = json_decode($open_ai->createThreadAndRun($data));
//        $assistant = json_decode($open_ai->retrieveAssistant($this->assistantId));
//        dd($assistant);
        $query = ['limit' => 10];
//        $steps = json_decode($open_ai->listRunSteps($run->thread_id, $run->id, $query));
        $runStatus = json_decode($open_ai->retrieveRun($run->thread_id,$run->id));
        while($runStatus->status != "completed") {
            sleep(1);
            $runStatus = json_decode($open_ai->retrieveRun($run->thread_id,$run->id));
        }
        $steps = json_decode($open_ai->listRunSteps($run->thread_id, $run->id, $query));
        $message = json_decode($open_ai->retrieveThreadMessage($run->thread_id, $steps->data[0]->step_details->message_creation->message_id));
        return $message->content[0]->text->value;
    }

}
