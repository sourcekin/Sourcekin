<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace SourcekinBundle\SimpleBus;

use SimpleBus\Message\Recorder\PublicMessageRecorder;
use SimpleBus\Message\Recorder\RecordsMessages;
use Sourcekin\Domain\Message\EventRecorder;

class EventRecorderAdapter  implements EventRecorder
{
    /**
     * @var RecordsMessages
     */
    protected $recorder;

    /**
     * EventRecorderAdapter constructor.
     *
     * @param RecordsMessages $recorder
     */
    public function __construct(RecordsMessages $recorder) { $this->recorder = $recorder; }


    public function messages()
    {
        return $this->recorder->recordedMessages();
    }

    public function erase()
    {
         $this->recorder->eraseMessages();
    }

    public function record($event)
    {
        $this->recorder->record($event);
    }

}