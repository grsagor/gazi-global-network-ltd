@extends('backend.layout.app')
@section('content')
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011-04-25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011-07-25</td>
                <td>$170,750</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#example').DataTable({
            paging: true,         // Enable pagination
            searching: true,      // Enable search box
            ordering: true,       // Enable column sorting
            info: true            // Show table information
        });
    });
</script>
@endsection