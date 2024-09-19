<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\Actions;
class Navbar extends Component
{
    use Actions;

    #[On('echo:notif,ReceivedNotification')]
    public function receiveEvent($message){
        switch (auth()->user()->user_type) {
            case 'Stakeholder':
                if ($message['uploaded'] != 'Stakeholder') {
                    $this->notification()->success(
                        $title = 'Notification',
                        $description = $message['details'],
                    );
                }
                break;

                case 'Superadmin':
                    $this->notification()->success(
                        $title = 'Notification',
                        $description = $message['details'],
                    );
                break;

                case 'Admin':
                   if ($message['uploaded'] == 'Employee' || $message['uploaded'] == 'Admin') {
                    $this->notification()->success(
                        $title = 'Notification',
                        $description = $message['details'],
                    );
                   }
                break;

                case 'Employee':
                    if ($message['uploaded'] == 'Employee' || $message['uploaded'] == 'Admin') {
                        $this->notification()->success(
                            $title = 'Notification',
                            $description = $message['details'],
                        );
                       }
                    break;

            default:
                # code...
                break;
        }
        $this->dispatch('notif');
    }


    #[On('notif')]
    public function render()
    {
        return view('livewire.navbar',[
            'notifications' => Notification::orderBy('created_at', 'DESC')->get()->take(5),
        ]);
    }
}
