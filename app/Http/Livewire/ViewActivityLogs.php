<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ActivityLog;
use Livewire\WithPagination;

class ViewActivityLogs extends Component
{
    use WithPagination;
    public $date;
    public $search;
    public function render()
    {
        if($this->date == "" && $this->search == ""){
            $data = ActivityLog::with(['user','user.banks','user.roles'])->orderBy('id','desc')->paginate(10);
        }else{
            $data = ActivityLog::with(['user','user.banks','user.roles']);
            if(!empty($this->date)){
                $data->where('created_at','LIKE','%'.$this->date.'%');
            }
            if (!empty($this->search)) {
                $data->whereHas('user.banks', function ($query) {
                    $query->where('bank_name', 'LIKE', '%' . $this->search . '%');
                });
            }
            $data = $data->orderBy('id','desc')->paginate(10);
        }
        return view('livewire.view-activity-logs',compact('data'));
    }
}
