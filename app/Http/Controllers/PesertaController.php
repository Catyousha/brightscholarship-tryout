<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTryout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\Console\Input\Input;

class PesertaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('isAdmin');
        $peserta = ($request->query('name')) ?
                                            User::like('name', $request->query('name'))
                                            ->where('role', 'student')
                                            ->where('acc_verified_at', '!=', null)
                                            ->orderBy('name')
                                            ->paginate(20)
                                            : User::where('role', 'student')
                                           ->where('acc_verified_at', '!=', null)
                                           ->orderBy('name')
                                           ->paginate(20);

        return view('peserta.list', compact('peserta'));
    }

    public function show_tunggu_acc(Request $request)
    {
        Gate::authorize('isAdmin');
        $peserta = ($request->query('name')) ?
                                    User::like('name', $request->query('name'))
                                    ->where('role', 'student')
                                    ->where('acc_verified_at', null)
                                    ->orderBy('name')
                                    ->paginate(20)
                                    : User::where('role', 'student')
                                    ->where('acc_verified_at', null)
                                    ->orderBy('name')
                                    ->paginate(20);

        return view('peserta.list_tunggu', compact('peserta'));

    }

    public function validate_acc(Request $request)
    {
        Gate::authorize('isAdmin');
        $user = User::findOrFail($request->user_id);
        if($request->decision == "_ACC"){
            $user->update(['acc_verified_at' => now()]);
        } else if($request->decision == "_REJECT"){
            $user->delete();
        }
        return response()->json(['data' => $request->decision]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('isAdmin');
        $peserta        = User::findOrFail($id);
        $tryout_peserta = $peserta->user_tryout;
        return view('peserta.detail', compact('peserta', 'tryout_peserta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('isAdmin');
        $user = User::findOrFail($id);
        $user->user_answer()->delete();
        $user->user_tryout()->delete();
        $user->delete();

        return redirect()->route('peserta.index')->with(['success' => 'Data peserta berhasil dihapus!']);
    }
}
