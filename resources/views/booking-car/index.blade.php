@extends('layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1 style="text-transform: uppercase;">
    Quản lý đặt xe
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'booking-car.index') }}">
     Đặt xe</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">

    <div class="col-md-12">
      <div id="content_alert"></div>
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('booking-car.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo booking</a>
      <a href="{{ route('drivers.create') }}" target="_blank" class="btn btn-primary btn-sm" style="margin-bottom:5px">Thêm tài xế</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('booking-car.index') }}" id="searchForm">

              <div class="form-group">
                  <input type="text" class="form-control daterange" autocomplete="off" name="range_date" value="{{ $arrSearch['range_date'] ?? "" }}" />
              </div>
            <div class="form-group">
              <input type="text" class="form-control" autocomplete="off" name="id_search" placeholder="PTX ID" value="{{ $arrSearch['id_search'] }}" style="width: 70px">
            </div>
            <div class="form-group">
              <select class="form-control select2" name="city_id" id="city_id">
                <option value="">--Tỉnh/thành--</option>
                @foreach($cityList as $city)
                <option value="{{ $city->id }}" {{ $arrSearch['city_id'] == $city->id  ? "selected" : "" }}>{{ $city->name }}
                </option>
                @endforeach
              </select>
            </div>
            @if(Auth::user()->role == 1 && !Auth::user()->view_only)
            <div class="form-group">
              <select class="form-control select2" name="driver_id" id="driver_id">
                <option value="">--Tài xế--</option>
                @foreach($driverList as $driver)
                <option value="{{ $driver->id }}" {{ $arrSearch['driver_id'] == $driver->id  ? "selected" : "" }}>{{ $driver->name }}
                  @if($driver->is_verify == 1)
                        - HĐ
                        @endif
                </option>
                @endforeach
              </select>
            </div>
            @endif

            <div class="form-group">
              <select class="form-control select2" name="car_cate_id" id="car_cate_id">
                <option value="">--Loại xe--</option>
                @foreach($carCate as $cate)
                <option value="{{ $cate->id }}" {{ $arrSearch['car_cate_id'] == $cate->id  ? "selected" : "" }}>{{ $cate->name }}</option>
                @endforeach
              </select>
            </div>
            @if(Auth::user()->role == 1 && !Auth::user()->view_only || Auth::user()->id == 23)
            <div class="form-group">
              <select class="form-control select2" name="user_id" id="user_id">
                <option value="">--Sales--</option>
                @foreach($listUser as $user)
                <option value="{{ $user->id }}" {{ $arrSearch['user_id'] == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                @endforeach
              </select>
            </div>
            @endif
            <div class="form-group">
              <select class="form-control select2" name="nguoi_thu_coc" id="nguoi_thu_coc">
                <option value="">--Người thu cọc--</option>
                @foreach($collecterList as $col)
                <option value="{{ $col->id }}" {{ $arrSearch['nguoi_thu_coc'] == $col->id ? "selected" : "" }}>{{ $col->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <select class="form-control select2" name="nguoi_thu_tien" id="nguoi_thu_tien">
                <option value="">--Người thu tiền--</option>
                @foreach($collecterList as $col)
                <option value="{{ $col->id }}" {{ $arrSearch['nguoi_thu_tien'] == $col->id ? "selected" : "" }}>{{ $col->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="phone" value="{{ $arrSearch['phone'] }}" placeholder="Số ĐT"  style="width: 100px">
            </div>
            <button type="submit" class="btn btn-info btn-sm" style="margin-top: -5px">Lọc</button>
            <div>
              <div class="form-group">
                <input type="checkbox" name="status[]" id="status_1" {{ in_array(1, $arrSearch['status']) ? "checked" : "" }} value="1">
                <label for="status_1">Mới</label>
              </div>
              <div class="form-group">
                &nbsp;&nbsp;&nbsp;<input type="checkbox" name="status[]" id="status_2" {{ in_array(2, $arrSearch['status']) ? "checked" : "" }} value="2">
                <label for="status_2">Hoàn Tất</label>
              </div>
              <div class="form-group" style="border-right: 1px solid #9ba39d">
                &nbsp;&nbsp;&nbsp;<input type="checkbox" name="status[]" id="status_3" {{ in_array(3, $arrSearch['status']) ? "checked" : "" }} value="3">
                <label for="status_3">Huỷ&nbsp;&nbsp;&nbsp;&nbsp;</label>
              </div>
              @if(Auth::user()->role == 1 && !Auth::user()->view_only && $city_id == 1)
              <div class="form-group" style="border-right: 1px solid #9ba39d">
                &nbsp;&nbsp;&nbsp;<input type="checkbox" name="no_driver" id="no_driver" {{ $arrSearch['no_driver'] == 1 ? "checked" : "" }} value="1">
                  <label for="no_driver">CHƯA CHỌN TÀI XẾ&nbsp;&nbsp;&nbsp;&nbsp;</label>
              </div>
              @endif
              @if(Auth::user()->role == 1 && !Auth::user()->view_only || Auth::user()->id == 23)
              <div class="form-group" style="float: right;">
                &nbsp;&nbsp;&nbsp;<input type="checkbox"name="unc0" id="unc0" {{ $arrSearch['unc0'] == 1 ? "checked" : "" }} value="1">
                <label for="unc0">Chưa check <span style="color: red">UNC</span></label>
              </div>
              @endif

            </div>
          </form>
        </div>
      </div>

      <div class="box">
        <div class="panel">
        <div class="panel-body">
          @if(Auth::user()->role == 1 && !Auth::user()->view_only)
        <div class="table-responsive" style="margin-top: 20px;">
          <table class="table table-bordered table-hover">
            <tr style="background-color: #ffff99">
              <th></th>
              @foreach($collecterList as $col)
              @if(in_array($col->id, [1, 9]))
              <th class="text-right">{{ $collecterNameArr[$col->id] }}</th>
              @endif
              @endforeach
              <th class="text-right">Tổng</th>
            </tr>
            <tr>
              <th>Tiền cọc</th>
              @foreach($collecterList as $col)
              @if(in_array($col->id, [1, 9]))
              <td class="text-right">{{ isset($arrThuCoc[$col->id]) && $arrThuCoc[$col->id] > 0 ? number_format($arrThuCoc[$col->id]) : '-' }}</td>
              @endif
              @endforeach
              <td class="text-right">
                {{ number_format($tong_coc) }}
              </td>
            </tr>
            <tr>
              <th>Tiền thu còn lại</th>
              @foreach($collecterList as $col)
              @if(in_array($col->id, [1, 9]))
              <td class="text-right">{{ isset($arrThuTien[$col->id]) && $arrThuTien[$col->id] > 0 ? number_format($arrThuTien[$col->id]) : '-' }}</td>
              @endif
              @endforeach
              <td class="text-right">
                {{ number_format($tong_thuc_thu) }}
              </td>
            </tr>
          </table>
        </div>
        @endif

        </ul>
        </div>
      </div>



        <div class="form-inline" style="padding: 5px">
          <div class="form-group">
             <select class="form-control select2 multi-change-column-value" data-column="nguoi_thu_coc">
                <option value="">--SET THU CỌC--</option>
                @foreach($collecterList as $col)
                <option value="{{ $col->id }}">{{ $col->name }}</option>
                @endforeach
              </select>

          </div>
          <div class="form-group">
             <select class="form-control select2 multi-change-column-value" data-column="nguoi_thu_tien">
                <option value="">--SET THU TIỀN--</option>
                @foreach($collecterList as $col)
                <option value="{{ $col->id }}">{{ $col->name }}</option>
                @endforeach
              </select>

          </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
            {{ $items->appends( $arrSearch )->links() }}
          </div>
          <div class="table-responsive">
            <div style="font-size: 18px;padding: 10px; border-bottom: 1px solid #ddd">
              Tổng <span style="color: red">{{ $items->total() }}</span> booking
            </div>
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%" class="text-center"><input type="checkbox" id="check_all" value="1"></th>
              <th class="text-center" width="1%">STT</th>
              <th width="200">Tên KH</th>
              <th class="text-center" width="100">Ngày đi</th>
              <th width="100">UNC</th>
              <th style="width: 200px">Đón/Trả</th>
              <th class="text-center" width="80">NL/TE/EB</th>
              <th class="text-right" width="100">Tổng tiền/Cọc</th>
              <th class="text-right" width="100">CÒN LẠI<br>Người thu</th>
              <th class="text-center" width="250">@if($city_id == 1) Tài xế @else Nhà xe @endif</th>
              @if(!Auth::user()->view_only)
              <th width="1%;white-space:nowrap">Thao tác</th>
              @endif
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
                 @php $arrEdit = array_merge(['id' => $item->id], $arrSearch) @endphp
              <tr id="row-{{ $item->id }}" @if($item->driver_id == 0) style="background-color:#dee0e3" @endif>
                 <td class="text-center" style="line-height: 30px">
                  <input type="checkbox" id="checked{{ $item->id }}" class="check_one" value="{{ $item->id }}">

                 {{ date('d/m', strtotime($item->created_at)) }}

                </td>
                <td class="text-center">{{ $i }}</td>
                <td>
                  <strong style="color: red;font-size: 16px">PTX{{ $item->id }}
                  @if($item->status == 1)
                  <span class="label label-info">MỚI</span>
                  @elseif($item->status == 2)
                  <span class="label label-default">HOÀN TẤT</span>
                  @elseif($item->status == 3)
                  <span class="label label-danger">HỦY</span>
                  @endif </strong>
                  <br>
                   <a style="font-size:17px" href="{{ route( 'booking-car.edit', $arrEdit) }}">{{ $item->name }}</a> - <a href="tel:{{ $item->phone }}">{{ $item->phone }}</a></a>
                  <br>
                  @if(Auth::user()->role == 1 && !Auth::user()->view_only  || Auth::user()->id == 23)
                    Sales:
                    @if($item->user)
                    {{ $item->user->name }}
                    @else
                      {{ $item->user_id }}
                    @endif
                  @endif

                </td>
                <td class="text-center" style="white-space: nowrap;" >
                  @if($item->status != 3)
                  {{ date('d/m', strtotime($item->use_date)) }} - {{ $item->time_pickup }}
                  <br>
                  <strong style="color: blue">{{ $item->carCate->name }}</strong>
                  @endif
                </td>
                <td>
                  @if($item->status != 3)
                  @foreach($item->payment as $p)
                  @if($p->type == 1)
                  <img src="{{ Helper::showImageNew($p->image_url)}}" width="80" style="border: 1px solid red" class="img-unc" >
                  @else
                  <br>+ {{number_format($p->amount) }} lúc {{ date('d/m/Y', strtotime($p->created_at)) }}
                  @endif
                  @endforeach
                  @endif
                </td>

                <td>
                @if($item->status != 3)
                  @foreach($item->locationList as $lo)
                  {{ $lo->location->name ?? '' }}<br>
                  @endforeach

                  <br>
                  <span style="color:red">
                    {{ $item->notes }}</span>
                  @endif
                </td>
                 <td class="text-center">
                  @if($item->status != 3)
                  {{ $item->adults }} / {{ $item->childs }} / {{ $item->infants }}
                  @endif

                </td>
                <td class="text-right">
                  @if($item->status != 3)
                  {{ number_format($item->total_price) }}/{{ number_format($item->tien_coc) }}
                  @endif
                </td>
                <td class="text-right">
                  @if($item->status != 3)
                  {{ number_format($item->con_lai) }}
                  @endif
                  <br>
                  @if($item->nguoi_thu_tien)
                  <span style="color: red">{{ $collecterNameArr[$item->nguoi_thu_tien] }}</span>
                  @endif
                </td>
                <td class="text-center" @if($item->driver_id == 0) style="background-color: #6ce8eb" @endif>


                  <!---Tài xế-->
                  @if($item->driver_id > 0)
                    <p style="background-color: #ccc;text-align: center;padding:5px"><strong style="color: red">{{ $item->driver->name }}</strong> <br><i class="glyphicon glyphicon-phone" style="font-size: 13px"></i> <a href="tel:{{ $item->driver->phone }}">{{ $item->driver->phone }}</a></p>
                  @else

                      @if(Auth::user()->role == 1 && !Auth::user()->view_only )
                      <div style="background-color: #6ce8eb !important;padding: 10px">
                        <select style="margin-bottom: 5px; width: 200px" class="form-control select2 change-column-value" data-id="{{ $item->id }}" data-column="driver_id">
                          <option value="">--Chọn tài xế--</option>
                          @foreach($driverList as $driver)
                          <option value="{{ $driver->id }}">{{ $driver->name }}
                            @if($driver->is_verify == 1)
                              - HĐ
                              @endif
                          </option>
                          @endforeach
                        </select>
                      </div>

                      @else
                      <p>--Chưa chọn TX-</p>
                      @endif

                  @endif <!--end tài xế-->

                </td>
                @if(!Auth::user()->view_only)
                <td style="white-space:nowrap; position: relative;" class="text-right">

                   <a class="btn btn-sm btn-success" title="Bill mua sắm/ăn uống" href="{{ route('booking-bill.index', ['id' => $item->id])}}&back_url={{ urlencode(Request::fullUrl()) }}"><i class="glyphicon glyphicon-list-alt"></i></a>

                <a href="{{ route( 'booking-payment.index', ['booking_id' => $item->id] ) }}&back_url={{ urlencode(Request::fullUrl()) }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-usd"></span></a>

                  @php $arrEdit = array_merge(['id' => $item->id], $arrSearch) @endphp
                  <a href="{{ route( 'booking-car.edit', $arrEdit ) }}&back_url={{ urlencode(Request::fullUrl()) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>
                  @if((Auth::user()->role == 1 && !Auth::user()->view_only || Auth::user()->id == 23) && $item->status == 1)
                  <a onclick="return callDelete('PTX{{ $item->id }} - {{ $item->name }}','{{ route( 'booking-car.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                  @endif
                  @if((Auth::user()->role == 1 && !Auth::user()->view_only || Auth::user()->id == 23) && $item->status == 1)
                    <br><input id="hoan_tat_{{ $item->id }}" type="checkbox" name="" class="change_status_bk" value="2" data-id="{{ $item->id }}">
                    <label for="hoan_tat_{{ $item->id }}">Hoàn tất</label>
                    @endif
                    @if(Auth::user()->role == 1 && !Auth::user()->view_only || Auth::user()->id == 23)
                  <br><input id="check_unc_{{ $item->id }}" type="checkbox" name="" class="change-column-value" value="{{ $item->check_unc == 1 ? 0 : 1 }}" data-id="{{ $item->id }}" data-column="check_unc" {{ $item->check_unc == 1 ? "checked" : "" }}>
                  <label for="check_unc_{{ $item->id }}">Đã check UNC</label>
                  @endif
                  <p style="clear: both; text-align: right;font-size: 13px" class="mt20"><a target="_blank" href="{{ route('history.booking', ['id' => $item->id]) }}">Xem lịch sử</a></p>
                </td>
                @endif
              </tr>
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
          </div>
          <div style="text-align:center">
            {{ $items->appends( $arrSearch )->links() }}
          </div>

          <div class="form-inline" style="padding: 5px">
            <div class="form-group">
               <select class="form-control select2 multi-change-column-value" data-column="nguoi_thu_coc">
                  <option value="">--SET THU CỌC--</option>
                  @foreach($collecterList as $col)
                  <option value="{{ $col->id }}">{{ $col->name }}</option>
                  @endforeach
                </select>

            </div>
            <div class="form-group">
               <select class="form-control select2 multi-change-column-value" data-column="nguoi_thu_tien">
                  <option value="">--SET THU TIỀN--</option>
                  @foreach($collecterList as $col)
                  <option value="{{ $col->id }}">{{ $col->name }}</option>
                  @endforeach
                </select>

            </div>
          </div>

        </div>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
</section>
<!-- /.content -->
</div>
<div class="modal fade" id="uncModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="text-align: center;">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" id="unc_img" style="width: 100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="table_name" value="articles">
@stop
<style type="text/css">
  label{
    cursor: pointer;
  }
</style>
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('#searchForm input[type=checkbox]').change(function(){
        $('#searchForm').submit();
      });
     $('#no_driver').change(function(){
      $('#searchForm').submit();
    });
    $('img.img-unc').click(function(){
      $('#unc_img').attr('src', $(this).attr('src'));
      $('#uncModal').modal('show');
    });
    $("#check_all").click(function(){
          $('input.check_one').not(this).prop('checked', this.checked);
      });
    $('.multi-change-column-value').change(function(){
      var obj = $(this);
      $('.check_one:checked').each(function(){
          $.ajax({
            url : "{{ route('booking.change-value-by-column') }}",
            type : 'GET',
            data : {
              id : $(this).val(),
              col : obj.data('column'),
              value: obj.val()
            },
            success: function(data){

            }
          });
      });

   });
  });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#btnExport').click(function(){
        var oldAction = $('#searchForm').attr('action');
        $('#searchForm').attr('action', "{{ route('export.cong-no-tour') }}").submit().attr('action', oldAction);
      });
      $('#temp').click(function(){
        $(this).parents('form').submit();
      });
    	$('.change_status').click(function(){
		      var obj = $(this);
		      $.ajax({
		        url : "{{ route('change-export-status') }}",
		        type : 'GET',
		        data : {
		          id : obj.data('id')
		        },
		        success: function(){
		          window.location.reload();
		        }
		      });
		    });
       $('.change_status_bk').click(function(){
          var obj = $(this);
          $.ajax({
            url : "{{ route('change-status') }}",
            type : 'GET',
            data : {
              id : obj.data('id')
            },
            success: function(){
              //window.location.reload();
            }
          });
        });
       $('.change-column-value').change(function(){
          var obj = $(this);
          $.ajax({
            url : "{{ route('booking.change-value-by-column') }}",
            type : 'GET',
            data : {
              id : obj.data('id'),
              col : obj.data('column'),
              value: obj.val()
            },
            success: function(data){
                console.log(data);
            }
          });
       });
      $('.hoa_hong_sales').blur(function(){
        var obj = $(this);
        $.ajax({
          url:'{{ route('save-hoa-hong')}}',
          type:'GET',
          data: {
            id : obj.data('id'),
            hoa_hong_sales : obj.val()
          },
          success : function(doc){

          }
        });

      });

    });
  </script>
@stop
