
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

@extends("welcome")
@section('content')
    <div class="flex items-center">
        <div class="ml-4 text-lg leading-7 font-semibold">مرحله چهارم</div>
    </div>

    <div class="mr-12">
        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
            خیلی خوبه که تا اینجا آمدی.<br>
            یادت باشه برای این مراحل راه حل های زیادی وجود داره و شما باید بهترین راه حلی که به ذهنت میرسه رو انجام بدی.<br>
            اگه با دقت دیتابیس رو نگاه کنی یک جدول میبینی به اسم user_attributes که ازت میخوام محتوای اون جدول رو در پایین صفحه نشون بدی و امکان سرچ در اون جدول داشته باشیم. بصورت ajax.<br>
            برای اینکار حتما از datatable یا یه ابزار خوب استفاده کن تا خیلی وقتتو نگیره. فقط سرچ تو ستون های جدول خیلی مهمه پس یادت نره.<br><br>

            <table id="myTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>شماره کاربر</th>
                    <th>نام کاربر</th>
                    <th>ایمیل</th>
                    <th>موبایل</th>
                    <th>آدرس</th>
                    <th>موجودی</th>
                </tr>
                </thead>
                {{-- <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> --}}
            </table>

            <div style="text-align:left;">
                <a class="next-lvl" href="{{ route('step5') }}">
                    مرحله بعد
                </a>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">
        $(function () {
          
          var table = $('#myTable').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('userattributes.index') }}",
              columns: [
                  {data: 'user.id', name: 'user.id'},
                  {data: 'user.name', name: 'user.name'},
                  {data: 'user.email', name: 'user.email'},
                  {data: 'mobile', name: 'mobile'},
                  {data: 'address', name: 'address'},                 
                  {data: 'credit', name: 'credit'},
                //   {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
          
        });
</script>


