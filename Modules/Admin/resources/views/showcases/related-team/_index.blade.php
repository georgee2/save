<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Related Team Members</h5>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTeamModal">
                <i class="fa fa-plus"></i> Add Team Member
            </button>
        </div>
        
        <div id="team-list">
            @if($showcase->teams->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="80">ID</th>
                                <th>Name (English)</th>
                                <th>Name (Arabic)</th>
                                <th>Added Date</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="team-table-body">
                            @foreach($showcase->teams as $teamMember)
                            <tr id="team-row-{{ $teamMember->pivot->id }}">
                                <td>{{ $teamMember->id }}</td>
                                <td>{{ $teamMember->name_english }}</td>
                                <td>{{ $teamMember->name_arabic }}</td>
                                <td>{{ $teamMember->pivot->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.team.show', ['id' => $teamMember->id]) }}" 
                                       class="btn btn-info btn-sm mr-1" 
                                       title="View Team Member Details"
                                       target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="deleteTeamMember({{ $teamMember->pivot->id }}, '{{ $teamMember->name_english }}')"
                                            title="Remove Team Member">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center" id="no-team-message">
                    <i class="fa fa-info-circle"></i> No team members added yet. Click "Add Team Member" to get started.
                </div>
            @endif
        </div>
    </div>
</div>

@include('admin::showcases.related-team._add_modal')
@include('admin::showcases.related-team._delete_modal')

