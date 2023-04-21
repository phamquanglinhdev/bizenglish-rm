@php
    /**
     * @var $entry
     */
@endphp

<a href="{{route($entry.".show",$id)}}" class="btn btn-sm text-primary btn-icon"><i
        class="text-success bx bxs-info-circle"></i></a>
<a href="{{route($entry.".edit",$id)}}" class="btn btn-sm text-primary btn-icon item-edit"><i
        class="text-warning bx bxs-edit"></i></a>
<a href="" class="btn btn-sm text-primary btn-icon item-edit"
   type="button" data-bs-toggle="offcanvas" data-bs-target="#delete-{{$id}}" aria-controls="offcanvasBottom"
><i class="text-danger bx bxs-trash"></i></a>

<div>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="delete-{{$id}}" aria-labelledby="offcanvasBottomLabel"
         aria-modal="true" role="dialog">
        <div class="offcanvas-header">
            <h5 id="offcanvasBottomLabel" class="offcanvas-title">Xóa dữ liệu ??</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Dữ liệu sẽ bị xóa cùng với tất cả các dữ liệu liên quan, vui lòng cân nhắc trước khi xóa</p>
            <form action="{{route($entry.".destroy",$id)}}" method="Post">
                @method("DELETE")
                @csrf
                <button type="submit" class="btn btn-danger me-2">Xác nhận xóa</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Hủy</button>
            </form>

        </div>
    </div>
</div>

