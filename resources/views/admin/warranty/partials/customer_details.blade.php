<ul class="list-group">
    <li class="list-group-item"><strong>Name:</strong> {{ $warranty->user->name }}</li>
    <li class="list-group-item"><strong>Email:</strong> {{ $warranty->user->email }}</li>
    <li class="list-group-item"><strong>Phone:</strong> {{ $warranty->user->phone_number }}</li>
    <li class="list-group-item"><strong>State -> City:</strong> {{ $warranty->user->state }} ->
        {{ $warranty->user->city }}</li>
    <li class="list-group-item"><strong>Address:</strong> {{ $warranty->user->address }}</li>
</ul>
