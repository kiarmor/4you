<?php
namespace App\Http\ViewComposers\Admin;
use Illuminate\View\View;
use App\Ticket;
use App\User;
use App\Withdraw;

class IsnewComposer {
    public $newTicketsQ;
    public $newUsersQ;
    public $newWithdrawsQ;

    public function __construct() {        
        $newTickets = Ticket::where("isnew", "1")->get();
        $this->newTicketsQ = count($newTickets);
        $newUsers = User::where("isnew", "1")->get();
        $this->newUsersQ = count($newUsers);
        $newWithdraws = Withdraw::where("isnew", "1")->get();
        $this->newWithdrawsQ = count($newWithdraws);
    }

    public function compose (View $view) {        
        $view
            ->with("newTicketsQ", $this->newTicketsQ)
            ->with("newUsersQ", $this->newUsersQ)
            ->with("newWithdrawsQ", $this->newWithdrawsQ);
    }
}