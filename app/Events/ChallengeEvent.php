<?php

namespace App\Events;

use App\Model\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChallengeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $challenger;
    public $id;
    public $challenge_id;

    /**
     * ChallengeEvent constructor.
     * @param User $challenger
     * @param int $id
     */
    public function __construct(User $challenger, $challenge_id, $id)
    {
        $this->id = $id;
        $this->challenger = $challenger;
        $this->challenge_id = $challenge_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->id);
    }

    /**
     * @return array
     */
//    public function broadcastWith()
//    {
//        return [
//            'id'    => $this->challenger->id,
//            'name'  => $this->challenger->name,
//            'email' => $this->challenger->email,
//             'challlenge_id' => $this->challenger->challenged()
//->where('challenged_id', $challenged_id)->first()->pivot->id;
//        ];
//    }
}
