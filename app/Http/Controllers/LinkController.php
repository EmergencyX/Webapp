<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Jobs\UpdateAggregator;
use EmergencyExplorer\Link;
use EmergencyExplorer\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class LinkController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Project $project)
    {
        $links = $project->links()->get();

        return view('project/links.edit', compact('project', 'links'));
    }

    function store(Request $request, Project $project)
    {
        $link = new Link;
        $link->url = $request->get('url');
        $link->name = $request->get('name');
        $link->type = $request->get('type');
        $link->project_id = $project->id;

        $link->save();

        $this->dispatch(new UpdateAggregator($project, $link));
        
        return redirect(action('LinkController@edit', $project));
    }

    public function update(Request $request, Project $project)
    {
        /** @var Collection $links */
        $links = $project->links()->get()->keyBy('id');
        $input = $request->get('links');

        foreach ($input as $id => $newLink) {
            $oldLink = $links->find($id);
            $oldLink->name = $newLink['name'];
            $oldLink->type = $newLink['type'];
            $oldLink->url = $newLink['url'];
            $oldLink->save();
        }

        return redirect(action('LinkController@edit', $project));
    }

    public function delete(Project $project, Link $link)
    {
        $link->delete();

        return redirect(action('LinkController@edit', $project));
    }
}
