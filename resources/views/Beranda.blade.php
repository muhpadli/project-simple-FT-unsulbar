@if (auth()->user()->roles_id == 1)
    @include('layout.Admin.Dashboard')
@elseif (auth()->user()->roles_id == 2)
    @include('layout.Pejabat.Dashboard')
@else
    @include('layout.Staf.Dashboard')
@endif
