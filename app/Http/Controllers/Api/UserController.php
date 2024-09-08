<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API WEB",
 *      description="Estudo da Tecnologia - Banco de Dados I",
 *      @OA\Contact(
 *          email="jmatheus_21@academico.ufs.br"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     description="Exibir todos os usuários",
     *     @OA\Response(response=200, description="Lista de usuários")
     * )
     */
    public function index () : JsonResponse {
        $users = User::orderby('cpf', 'DESC')->get();
        return response()->json([
            'status' => true,
            'users' => $users
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     description="Cadastrar novo usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cpf","nome","data_nascimento"},
     *             @OA\Property(property="cpf", type="unsignedBigInteger", example=154),
     *             @OA\Property(property="nome", type="string", example="João Alves"),
     *             @OA\Property(property="data_nascimento", type="string", format="date", example="1990-06-10")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Usuário criado com sucesso"),
     *     @OA\Response(response=400, description="Falha na requisição")
     * )
     */
    public function store (UserRequest $request) : JsonResponse {
        DB::beginTransaction();

        try {
            
            $user = User::create([
                'cpf' => $request->cpf,
                'nome' => $request->nome,
                'data_nascimento' => $request->data_nascimento
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário cadastrado'
            ], 201);
            
        } catch(Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Usuário não cadastrado'
            ], 400);
        }
    }
}