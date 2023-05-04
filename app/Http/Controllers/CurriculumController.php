<?php

namespace App\Http\Controllers;

use App\Http\Requests\approveCurriculum;
use App\Models\Curriculum;
use App\Http\Requests\StoreCurriculumRequest;
use App\Http\Requests\SubmitRevisionRequest;
use App\Http\Requests\UpdateCurriculumRequest;
use App\Http\Requests\UpdateRevisionRequest;
use App\Http\Resources\CurriculumResource;
use App\Models\CurriculumOld;
use App\Models\CurriculumRevision;
use Database\Factories\CurriculumFactory;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $curriculums = Curriculum::all();
        $curriculums = Curriculum::with('user.profile', 'department', 'approvedBy.profile')->orderByDesc('created_at')->get();
        $curriculums = $curriculums->map(function ($cur) {
            $cur->is_new = $cur->created_at->diffInDays(now()) < 7;
            return $cur;
        });
        return response()->json($curriculums);
    }

    public function curriculumRevisionList()
    {
        $revisions = CurriculumRevision::with('curriculum.department', 'user.profile', 'approvedBy.profile')->orderByDesc('created_at')->get();

        $revisions = $revisions->map(function ($rev) {
            $rev->is_new = $rev->created_at->diffInDays(now()) < 7;
            return $rev;
        });

        return $revisions;
        // return response()->json($curriculums);
    }

    public function oldRevisionList()
    {
        $oldRevisions = CurriculumOld::orderBy('created_at', 'desc')->get();

        return $oldRevisions;
    }

    public function curriculumRevision($id)
    {
        return CurriculumRevision::with('curriculum.department', 'user.profile')->find($id);
        // return response()->json($curriculums);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function approveCurriculum(Request $request, $id)
    {
        // if ($request->user()->tokenCan('can_approve_revision')) {
        if (true) {
            $curriclum = Curriculum::find($id);

            if (!$curriclum) {
                return response()->json(['message' => 'cannot find pending curriclum'], 404);
            }
            $curriclum->update([
                'status' => 'a',
                'approve_by' => $request->user()->id
            ]);
            return response()->json(['message' => 'success', 'curriclum' => $curriclum]);
        }
        return response()->json(['message' => 'you are not authorized'], 403);
    }

    public function submitRevision(SubmitRevisionRequest $request)
    {
        // if ($request->user()->tokenCan('can_submit_revision')) {
        if (true) {
            $curriculum = CurriculumRevision::create($request->all());
            return response()->json(['message' => 'success', 'curriculum' => $curriculum]);
        }
        return response()->json(['message' => 'you are not authorized'], 403);
    }

    public function approveRevision(Request $request, $id)
    {
        // if ($request->user()->tokenCan('can_approve_revision')) {
        if (true) {
            $curriculum = CurriculumRevision::find($id);
            if (!$curriculum) {
                return response()->json(['message' => 'cannot find revision curriclum'], 404);
            }

            $refereceCurriculum = Curriculum::find($curriculum->curriculum_id);
            if (!$refereceCurriculum) {
                return response()->json(['message' => 'cannot find revision curriclum'], 404);
            }

            CurriculumOld::create([
                'curriculum_id' => $refereceCurriculum->id,
                'metadata' => $refereceCurriculum->metadata,
                'version' => $refereceCurriculum->version,
                'increment_version' => $curriculum->increment_version
            ]);

            // $asd = $refereceCurriculum->version + .1;
            $refereceCurriculum->metadata = $curriculum->metadata;
            $refereceCurriculum->version = $curriculum->increment_version ? $refereceCurriculum->version  + .1 : $refereceCurriculum->version;
            $refereceCurriculum->save();

            $curriculum->update([
                'status' => 'a',
                'approve_by' => $request->user()->id
            ]);

            return response()->json(CurriculumRevision::with('approvedBy.profile')->find($curriculum->id));
        }
        return response()->json(['message' => 'you are not authorized'], 403);
    }

    public function updateRevision(UpdateRevisionRequest $request)
    {
        $curriculum = CurriculumRevision::find($request->id);
        // $curriculum->update($request->all());
        $curriculum->update([
            'metadata' => $request->metadata,
            'increment_version' => $request->increment_version
        ]);
        return response()->json($curriculum);
    }



    /**
     * Store a newly created resource in storage.
     */



    public function store(StoreCurriculumRequest $request)
    {
        return Curriculum::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // return $curriculum;
        $curriculum = Curriculum::with('user.profile', 'department')->find($id);

        if (!$curriculum) {
            return response()->json(['message' => 'cannot find curriculum'], 404);
        }
        return $curriculum;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curriculum $curriculum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurriculumRequest $request, Curriculum $curriculum)
    {
        $curriculum->update($request->all());
        return response()->json($curriculum);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum)
    {
        //
    }
}
