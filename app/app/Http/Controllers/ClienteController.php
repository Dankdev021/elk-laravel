<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ElasticsearchLogger;

class ClienteController extends Controller
{
    public function store(Request $request, ElasticsearchLogger $elasticSearchLogger)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:clientes,email',
        ]);

        $cliente = Cliente::create($data);

        Log::info('Novo cliente cadastrado', [
            'cliente_id' => $cliente->id,
            'nome' => $cliente->nome,
            'email' => $cliente->email,
            'ip' => $request->ip(),
            'acao' => 'criado',
        ]);

        $elasticSearchLogger->log('user_logs', [
            'event' => 'user_created',
            'user_id' => $cliente->id,
            'name' => $cliente->nome,
            'timestamp' => now(),
        ]);
        return response()->json($cliente, 201);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $data = $request->validate([
            'nome' => 'string',
            'email' => 'email|unique:clientes,email,' . $id,
        ]);

        $cliente->update($data);

        Log::info('Cliente atualizado', [
            'cliente_id' => $cliente->id,
            'nome' => $cliente->nome,
            'email' => $cliente->email,
            'ip' => $request->ip(),
            'acao' => 'atualizado',
        ]);

        return response()->json($cliente);
    }
}

