<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {

        $users = User::get();
        $comments = Comment::get();

        $names = $users->reject(fn ($user) => $user->active === 0)
                            ->map(fn ($user) => $user->name);

        // DIFF -> DADOS DIFERENTES DOS PASSADOS
        $usersDif = $users->diff(User::where('name', 'Reba King')->get());

        // EXCEPT -> TODOS OS DADOS COM EXCEÇÃO DOS ID'S PASSADOS NO ARRAY
        $usersExcept = $users->except([2,4,6]);

        // INTERSECT -> TODOS OS DADOS DE ACORDO COM O QUE FOI PASSADO NO WHERE
        $usersIntersect = $users->intersect(User::whereIn('id', [1,2])->get());

        // FIND -> DADOS DE ACORDO COM O ID PASSADO
        $userFind = $users->find(8);

        // FRESH -> DADOS COM DADOS RELACIONAIS. USUÁRIOS COM COMENTÁRIOS. A FUNÇÃO PODE SER CHAMADA SEM NENHUM PARÂMETRO ADICIONAL
        //          OS DADOS RELACIONAIS SERÃO CARREGADOS ANTECIPADAMENTE E PODERAO SER ACESSADOS NORMALMENTE
        //          EX: $usersFresh = $users->fresh(); -> $userFresh[0]->comments
        $usersFresh = $users->fresh('comments');

        // LOAD -> DADOS COM DADOS RELACIONAIS. USUÁRIOS COM COMENTÁRIOS
        $usersLoad = $users->load(['comments' => fn ($query) => $query->where('title','!=','teste title')]);

        // LOADMISSING -> ????
        $usersLoadMissing = $users->loadMissing(['comments' => fn ($query) => $query->where('title', 'teste title')]);

        // MODELKEYS -> RETORNA ID'S
        $usersModelKeys = $users->modelKeys();

        // MAKEVISIBLE -> RETORNA CAMPOS QUE ESTÃO NA VARIAVEL $HIDDEN NO MODEL
        //$usersMakeVisible = $users->makeVisible(['password', 'remember_token']);

        // MAKEHIDDEN -> OCULTA CAMPOS QUE SÃO VISÍVEIS
        //$usersMakeHidden = $users->makeHidden(['name', 'email']);

        // ONLY -> RETORNA USUARIOS DOS SEGUINTES ID'S
        $usersOnly = $users->only([1,2,3]);

        $usersWhereNull = $users->whereNull('email_verified_at');
        
        // TOQUERY -> ATUALIZA TODOS OS REGISTROS DO BANCO
        // $usersToQuery = $users
        //     ->toQuery()
        //     ->update([
        //         "created_at" => "2022-12-07 20:37:37"
        //     ]);

        // UNIQUE -> REMOVE TODOS SMOOS REGISTROS DE MESMO ID. VALE PARA CHAVES ESTRANGEIRAS
        // users->unique() NÃO RETORNA COMENTARIO DE ME ID
        $usersUnique = $users->unique();

        return view('welcome', [
            "users" => $users,
            "usersDiff" => $usersDif,
            "usersExcept" => $usersExcept,
            "usersIntersect" => $usersIntersect,
            "userFind" => $userFind,
            "userFresh" => $usersFresh,
            "userLoad" => $usersLoad,
            "usersLoadMissing" => $usersLoadMissing,
            "usersModelKeys" => $usersModelKeys,
            "usersOnly" => $usersOnly,
            "usersWhereNull" => $usersWhereNull,
            "usersUnique" => $usersUnique,
            "names" => $names,
        ]);
    }
}
