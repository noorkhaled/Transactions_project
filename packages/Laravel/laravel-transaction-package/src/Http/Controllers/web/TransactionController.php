<?php

namespace Laravel\LaravelTransactionPackage\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Laravel\LaravelTransactionPackage\Models\Transactions;

class TransactionController extends Controller
{
    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function accountStatement($id,$lang): \Illuminate\Foundation\Application|View|Factory|Application
    {
        if (!in_array($lang,['en','ar'])){
            abort(400);
        }
        App::setLocale($lang);
        $user = User::findOrFail($id);
        $accountStatements = Transactions::getUserTransactions($id);
        return view('accountStatement', [
            'user' => $user,
            'accountStatements' => $accountStatements
        ]);
    }
}
