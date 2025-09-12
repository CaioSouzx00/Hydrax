<?php

namespace App\Http\Controllers;

use App\Models\FornecedorPendente;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\FornecedorAprovadoMail;
use App\Mail\FornecedorRejeitadoMail;

class FornecedorController extends Controller
{
    // Lista todos os produtos do fornecedor logado
    public function index()
    {
        $fornecedor = auth()->guard('fornecedores')->user();
        $produtos = ProdutoFornecedor::where('fornecedor_id', $fornecedor->id_fornecedores)->get();

        return view('fornecedores.produtos.index', compact('produtos'));
    }

    // Formulário de criação
    public function create()
    {
        return view('fornecedores.produtos.create');
    }

    // Salvar novo produto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'categoria' => 'required|string|max:100',
            'tamanhos_disponiveis' => 'nullable|array',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'estoque_imagem.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|in:ATIVO,INATIVO'
        ]);

        $fornecedor = auth()->guard('fornecedores')->user();

        $fotos = [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $fotos[] = $foto->store('produtos', 'public');
            }
        }

        $estoqueImgs = [];
        if ($request->hasFile('estoque_imagem')) {
            foreach ($request->file('estoque_imagem') as $img) {
                $estoqueImgs[] = $img->store('estoque', 'public');
            }
        }

        ProdutoFornecedor::create([
            'fornecedor_id' => $fornecedor->id_fornecedores,
            'nome' => $validated['nome'],
            'preco' => $validated['preco'],
            'categoria' => $validated['categoria'],
            'tamanhos_disponiveis' => json_encode($validated['tamanhos_disponiveis'] ?? []),
            'fotos' => json_encode($fotos),
            'estoque_imagem' => json_encode($estoqueImgs),
            'status' => $validated['status'] ?? 'ATIVO'
        ]);

        return redirect()->route('fornecedores.produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    // Formulário de edição
    public function edit($id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);
        return view('fornecedores.produtos.edit', compact('produto'));
    }

    // Atualizar produto
    public function update(Request $request, $id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'categoria' => 'required|string|max:100',
            'tamanhos_disponiveis' => 'nullable|array',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'estoque_imagem.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|in:ATIVO,INATIVO'
        ]);

        // Atualiza imagens se houver upload
        $fotos = json_decode($produto->fotos, true) ?? [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $fotos[] = $foto->store('produtos', 'public');
            }
        }

        $estoqueImgs = json_decode($produto->estoque_imagem, true) ?? [];
        if ($request->hasFile('estoque_imagem')) {
            foreach ($request->file('estoque_imagem') as $img) {
                $estoqueImgs[] = $img->store('estoque', 'public');
            }
        }

        $produto->update([
            'nome' => $validated['nome'],
            'preco' => $validated['preco'],
            'categoria' => $validated['categoria'],
            'tamanhos_disponiveis' => json_encode($validated['tamanhos_disponiveis'] ?? []),
            'fotos' => json_encode($fotos),
            'estoque_imagem' => json_encode($estoqueImgs),
            'status' => $validated['status'] ?? $produto->status
        ]);

        return redirect()->route('fornecedores.produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    // Excluir produto
    public function destroy($id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);

        // Remove fotos do storage
        foreach (json_decode($produto->fotos ?? '[]', true) as $foto) {
            Storage::disk('public')->delete($foto);
        }
        foreach (json_decode($produto->estoque_imagem ?? '[]', true) as $img) {
            Storage::disk('public')->delete($img);
        }

        $produto->delete();
        return redirect()->route('fornecedores.produtos.index')->with('success', 'Produto excluído com sucesso!');
    }

public function toggleProduto($id)
{
    $produto = ProdutoFornecedor::findOrFail($id);

    // Alterna entre 0 e 1
    $produto->ativo = !$produto->ativo;
    $produto->save();

    $status = $produto->ativo ? 'ATIVO' : 'INATIVO';

    return redirect()->back()->with('success', "Produto atualizado para {$status} com sucesso!");
}

}
