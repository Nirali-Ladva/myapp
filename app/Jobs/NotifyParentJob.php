<?php
namespace App\Jobs;

use App\Models\ParentModel;
use App\Models\Child;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChildLinkedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyParentJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $parentId;
    public $childId;

    public function __construct($parentId, $childId)
    {
        $this->parentId = $parentId;
        $this->childId = $childId;
    }

    public function handle()
    {
        $parent = ParentModel::find($this->parentId);
        $child = Child::find($this->childId);
        if (!$parent || !$child || !$parent->email) return;

        Mail::to($parent->email)->send(new ChildLinkedMail($parent, $child));
    }
}
