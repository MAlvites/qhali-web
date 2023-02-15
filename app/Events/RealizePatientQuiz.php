<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RealizePatientQuiz implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $quizId;
    public $patientId;
    public $botId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $quizId, int $patientId, int $botId)
    {
        $this->quizId = $quizId;
        $this->patientId = $patientId;
        $this->botId = $botId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['realize-quiz-channel'];
    }

    public function broadcastAs()
    {
        return 'realize-quiz-event-'.$this->botId;
    }
}
