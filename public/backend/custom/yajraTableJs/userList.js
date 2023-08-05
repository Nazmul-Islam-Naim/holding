<script>
	$(document).ready(function() {
		'use strict';

		var buTable = $('#example').DataTable({
			ajax: "{{route('all-users')}}",
			serverSide: true,
			processing: true,
      // "perPageLength": 100,
      "lengthMenu": [ 50, 100, 150, 200, 250 ],
			aaSorting: [
				[0, "asc"]
			],

			columns: [
        {data: 'DT_RowIndex'},
				{data: 'name'},
				{data: 'dob'},
				{data: 'gender'},
				{data: 'phone'},
				{data: 'address'},
				{data: 'company'},
        {
					data: 'status',
					render: function(data, type, row) {
						if (data == 1) {
							return "<a class='btn btn-xs btn-warning' data-id='" + row.id + "'>Active</a>";
						} else {
							return "<a class='btn btn-xs btn-success' data-id='" + row.id + "'>Deactive</a>";
						}

					}

				},
				{
          data: 'action',
          orderable:true,
          searchable:true
				}
			]
    });

		});
  </script>