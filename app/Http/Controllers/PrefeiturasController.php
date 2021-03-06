<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Prefeituras;
use App\Cidades;

class PrefeiturasController extends Controller {
    
	public function index() {
		$prefeituras = DB::table('prefeituras')->orderBy('id', 'asc')->get();
		return view('prefeituras.index', compact('prefeituras'));
	}

	public function create() {
		return view('prefeituras.create');
	}

	public function store(Request $request) {
		$cidade = Cidades::find($request->cidade);

		$novaPrefeitura = new Prefeituras();
		$novaPrefeitura->cnpj 		= $request->cnpj;
		$novaPrefeitura->cidade 	= $cidade->nome;
		$novaPrefeitura->endereco 	= $request->endereco;
		$novaPrefeitura->numero 	= $request->numero;
		$novaPrefeitura->cidade_id 	= $request->cidade;
		$novaPrefeitura->save();

		return redirect()->route('prefeituras')->with('sucesso', 'Nova Prefeitura criada com sucesso!');
	}

	public function exclude(Request $request) {
		try {
            Prefeituras::find($request->id)->delete();
			return response()->json(['response' => 'Sucesso_Excluir']);
        } catch(QueryException $e) {
			return response()->json(['response' => 'Erro_Excluir']);
        }
	}

	public function edit($id) {
		$prefeitura = Prefeituras::find($id);
		return view('prefeituras.edit', compact('prefeitura'));
	}

	public function update(Request $request, $id) {
		$cidade = Cidades::find($request->cidade);

		$pref = Prefeituras::find($id);
		$pref->cnpj 		= $request->cnpj;
		$pref->cidade 		= $cidade->nome;
		$pref->endereco 	= $request->endereco;
		$pref->numero 		= $request->numero;
		$pref->cidade_id 	= $request->cidade;
		$pref->save();

		return redirect()->route('prefeituras')->with('sucesso_edicao', 'Prefeitura editada com sucesso!');
	}

}
