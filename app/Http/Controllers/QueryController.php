<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;

class QueryController extends Controller
{
    // PUNTO 2: Recupera todos los pedidos asociados al usuario con ID 2.
    public function ej2_qb()
    {
        $orders = DB::table('orders')->where('user_id', 2)->get();
        return response()->json($orders);
    }

    public function ej2_eloquent()
    {
        //$user = User::find(2);
        //$orders = $user->orders; // Usando la relación definida en el modelo User
        //return response()->json($orders);

        $orders = Order::where('user_id', 2)->get();
        return response()->json($orders);
    }

    // PUNTO 3: Recupera todos los pedidos + nombre y correo de usuario (JOIN)
    public function ej3_qb()
    {
        $results = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name', 'users.email')
            ->get();

        return response()->json($results);
    }

    // PUNTO 4: Recupera todos los pedidos cuyo total este entre $100 y $250
    public function ej4_qb()
    {
        $orders = DB::table('orders')
            ->whereBetween('total', [100, 250])
            ->get();

        return response()->json($orders);
    }

    // PUNTO 5: Usuarios que su nombre empiece con R. Si es vacío, devolver excepción
    public function ej5_qb()
    {
        $users = DB::table('users')
            ->where('name', 'like', 'R%')
            ->get();

        if ($users->isEmpty()) {
            return response()->json(['error' => 'No se encontraron usuarios con nombre que empiecen con R.'], 404);
        } else {
            return response()->json($users);
        }
    }

    // PUNTO 6: Conteo de todos los registros de ordenes del usuario con ID 5 y tambien la sumatoria de todos los totales de sus ordenes
    public function ej6_qb()
    {
        $orderCount = DB::table('orders')
            ->where('user_id', 5)
            ->count();

        $totalSum = DB::table('orders')
            ->where('user_id', 5)
            ->sum('total');

        return response()->json([
            'userId' => 5,
            'NumeroOrdenes' => $orderCount,
            'TotalSum' => $totalSum,
        ]);
    }

    // PUNTO 7: Todos los pedidos ordenados descendentemente por total unido con la información de sus usuarios
    public function ej7_qb()
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.product', 'orders.total', 'orders.quantity', 'users.name', 'users.email')
            ->orderBy('orders.total', 'desc')
            ->get();

        return response()->json($orders);
    }

    // PUNTO 8: Obtén la suma total del campo "total" en la tabla de pedidos.
    public function ej8_qb()
    {
        $sumaTotal = DB::table('orders')->sum('total');

        return response()->json([
            'suma_total_pedidos' => (float) $sumaTotal
        ]);
    }

    // PUNTO 9: Encuentra el pedido más económico, junto con el nombre del usuario asociado.
    public function ej9_qb()
    {
        $cheapest = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.id', 'orders.product', 'orders.quantity', 'orders.total', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('orders.total', 'asc')
            ->first();

        if (!$cheapest) {
            return response()->json(['error' => 'No hay pedidos.'], 404);
        }

        return response()->json($cheapest);
    }

    // PUNTO 10: Obtén el producto, la cantidad y el total de cada pedido, agrupándolos por usuario.
    public function ej10_qb()
    {
        $results = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                DB::raw('GROUP_CONCAT(orders.product SEPARATOR ", ") as productos'),
                DB::raw('SUM(orders.quantity) as cantidad_total'),
                DB::raw('SUM(orders.total) as total_por_usuario')
            )
            ->groupBy('users.id', 'users.name')
            ->get();

        return response()->json($results);
    }
}
