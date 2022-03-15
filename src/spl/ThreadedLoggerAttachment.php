<?php

/**
 *
 *    ____ _                   _
 *  / ___| | _____      _____| |_ ___  _ __   ___
 * | |  _| |/ _ \ \ /\ / / __| __/ _ \| '_ \ / _ \
 * | |_| | | (_) \ V  V /\__ \ || (_) | | | |  __/
 *  \____|_|\___/ \_/\_/ |___/\__\___/|_| |_|\___|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Glowstone (Lunarelly)
 * @link https://github.com/Lunarelly
 *
 */

abstract class ThreadedLoggerAttachment extends \Threaded implements \LoggerAttachment
{

    /** @var \ThreadedLoggerAttachment */
    protected $attachment = null;

    /**
     * @param mixed $level
     * @param string $message
     */
    public final function call($level, $message)
    {
        $this->log($level, $message);
        if ($this->attachment instanceof \ThreadedLoggerAttachment) {
            $this->attachment->call($level, $message);
        }
    }

    /**
     * @param ThreadedLoggerAttachment $attachment
     */
    public function addAttachment(\ThreadedLoggerAttachment $attachment)
    {
        if ($this->attachment instanceof \ThreadedLoggerAttachment) {
            $this->attachment->addAttachment($attachment);
        } else {
            $this->attachment = $attachment;
        }
    }

    /**
     * @param ThreadedLoggerAttachment $attachment
     */
    public function removeAttachment(\ThreadedLoggerAttachment $attachment)
    {
        if ($this->attachment instanceof \ThreadedLoggerAttachment) {
            if ($this->attachment === $attachment) {
                $this->attachment = null;
                foreach ($attachment->getAttachments() as $attachment) {
                    $this->addAttachment($attachment);
                }
            }
        }
    }

    public function removeAttachments()
    {
        if ($this->attachment instanceof \ThreadedLoggerAttachment) {
            $this->attachment->removeAttachments();
            $this->attachment = null;
        }
    }

    /**
     * @return \ThreadedLoggerAttachment[]
     */
    public function getAttachments()
    {
        $attachments = [];
        if ($this->attachment instanceof \ThreadedLoggerAttachment) {
            $attachments[] = $this->attachment;
            $attachments += $this->attachment->getAttachments();
        }

        return $attachments;
    }
}