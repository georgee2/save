<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Related Projects</h5>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProjectModal">
                <i class="fa fa-plus"></i> Add Project
            </button>
        </div>
        
        <div id="projects-list">
            @if($showcase->projects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="80">ID</th>
                                <th>Project Name (English)</th>
                                <th>Project Name (Arabic)</th>
                                <th>Added Date</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="projects-table-body">
                            @foreach($showcase->projects as $project)
                            <tr id="project-row-{{ $project->pivot->id }}">
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->title_english }}</td>
                                <td>{{ $project->title_arabic }}</td>
                                <td>{{ $project->pivot->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('project.show', ['id' => $project->id]) }}" 
                                       class="btn btn-info btn-sm mr-1" 
                                       title="View Project Details"
                                       target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="deleteProject({{ $project->pivot->id }}, '{{ $project->title_english }}')"
                                            title="Remove Project">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center" id="no-projects-message">
                    <i class="fa fa-info-circle"></i> No projects added yet. Click "Add Project" to get started.
                </div>
            @endif
        </div>
    </div>
</div>

@include('admin::showcases.related-projects._add_modal')
@include('admin::showcases.related-projects._delete_modal')

