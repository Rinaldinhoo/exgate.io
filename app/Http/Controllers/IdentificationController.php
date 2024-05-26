<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IdentificationController extends Controller
{
    public function save(Request $request)
    {
        $request->validate([
            'documentfront' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'documentback' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'selfiedocument' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $user = Auth::user();

        try {
            $document = Document::where('user_id', $user->id)->whereIn('status', ['Pendente', 'Concluido'])->first();
            
            if ($document) {
                dd('ae');
                return back()->withErrors(['custom_error' => 'Já possui documento pendente ou concluído.']);
            }

            DB::beginTransaction();

            $documentFrontName = 'document_front_' . uniqid() . '.' . $request->file('documentfront')->extension();
            $documentBackName = 'document_back_' . uniqid() . '.' . $request->file('documentback')->extension();
            $selfieDocumentName = 'selfie_document_' . uniqid() . '.' . $request->file('selfiedocument')->extension();

            $documentFrontPath = $request->file('documentfront')->storeAs('documents', $documentFrontName, 'public');
            $documentBackPath = $request->file('documentback')->storeAs('documents', $documentBackName, 'public');
            $selfieDocumentPath = $request->file('selfiedocument')->storeAs('documents', $selfieDocumentName, 'public');

            Document::create([
                'user_id' => $user->id,
                'documentfront' => Storage::disk('public')->url($documentFrontPath),
                'documentback' => Storage::disk('public')->url($documentBackPath),
                'selfiedocument' => Storage::disk('public')->url($selfieDocumentPath),
                'status' => 'Pendente',
            ]);

            DB::commit();
            return back()->with('success', 'Documentos carregados com sucesso!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Log::error('Erro ao salvar documentos: ' . $e->getMessage());
            return back()->withErrors(['custom_error' => 'Erro ao salvar documentos. Por favor, tente novamente.']);
        }
    }
}