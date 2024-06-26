<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;
use Orhanerday\OpenAi\OpenAi;

class OpenAiService
{
    protected $apiKey;
    protected $baseUrlTheads = 'https://api.openai.com/v1/threads';

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->assistantId = 'asst_LiU7vdv0QH4HpiLKYeVTsT3r';

    }

    public function generateText($threadId, $promt)
    {
        $open_ai_key = $this->apiKey;
        $open_ai = new OpenAi($open_ai_key);
        $data = [
            'role' => 'user',
            'content' => $promt,
        ];


        $messageCreated = json_decode($open_ai->createThreadMessage($threadId, $data));

        $dataAssistant = $data = ['assistant_id' => $this->assistantId];
        $run = json_decode($open_ai->createRun($threadId,$dataAssistant));

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

    public function createThread(){
        $open_ai_key = $this->apiKey;
        $open_ai = new OpenAi($open_ai_key);
        $data = [
            'messages' => [
                [
                    'role' => 'user',
                    'content' => '',
                    'file_ids' => [],
                ],
            ],
        ];

        $thread = json_decode($open_ai->createThread($data));
        return $thread->id;

    }

}
