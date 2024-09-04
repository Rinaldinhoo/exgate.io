<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Config;

use App\Models\TransactionHistory;

use App\Models\Wallet;

use Log;

class AktaController extends Controller
{

    public function webhook(Request $request)
    {
        try {
            $data = $request->data;

            if ($data['paymentMethod'] != 'pix' && $data["status"] != 'paid') {
                throw new \Exception('Status está incoreto');
            }
            
            $transaction = TransactionHistory::where('codepix', $data['id'])
                ->where('status', 'Pendente')
                ->first();
            
            if ($transaction && $transaction->status == 'Pendente') {
                $wallet = Wallet::where('id', $transaction->wallet_id)->first();
                $taxa = $transaction->amount * 0.03;
                $wallet->update([
                    'amountbrl' => $wallet->amountbrl + ($transaction->amount - $taxa)
                ]);

                $transaction->update([
                    'status' => 'Concluido'
                ]);
            }
            
            return response()->json(['data' => 'Atualizacao'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 200);
        }
    }

    public function status(Request $request)
    {
        try {
            $transaction = TransactionHistory::where('codepix', $request->idTransaction)
                ->first();

            return response()->json(['status' => $transaction->status??null], 200);
        }  catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 200);
        }
    }
}
