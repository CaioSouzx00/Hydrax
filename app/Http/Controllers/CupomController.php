<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cupom;

class CupomController extends Controller
{
    // Listar todos os cupons
    public function index()
    {
        $cupons = Cupom::orderBy('created_at', 'desc')->get();
        return view('admin.cupons.index', compact('cupons'));
    }

    // Formulário de criação
    public function create()
    {
        return view('admin.cupons.create');
    }

    // Salvar cupom
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:cupons,codigo',
            'tipo' => 'required|in:percentual,valor',
            'valor' => 'required|numeric|min:0.01',
            'validade' => 'nullable|date|after_or_equal:today',
            'uso_maximo' => 'nullable|integer|min:1',
        ]);

        Cupom::create($request->all());

        return redirect()->route('admin.cupons.index')->with('success', 'Cupom criado com sucesso!');
    }

    // Formulário de edição
    public function edit($id)
    {
        $cupom = Cupom::findOrFail($id);
        return view('admin.cupons.edit', compact('cupom'));
    }

    // Atualizar cupom
    public function update(Request $request, $id)
    {
        $cupom = Cupom::findOrFail($id);

        $request->validate([
            'codigo' => 'required|unique:cupons,codigo,'.$cupom->id_cupom.',id_cupom',
            'tipo' => 'required|in:percentual,valor',
            'valor' => 'required|numeric|min:0.01',
            'validade' => 'nullable|date|after_or_equal:today',
            'uso_maximo' => 'nullable|integer|min:1',
        ]);

        $cupom->update($request->all());

        return redirect()->route('admin.cupons.index')->with('success', 'Cupom atualizado com sucesso!');
    }

    // Deletar cupom
    public function destroy($id)
    {
        $cupom = Cupom::findOrFail($id);
        $cupom->delete();

        return redirect()->route('admin.cupons.index')->with('success', 'Cupom deletado com sucesso!');
    }
}
