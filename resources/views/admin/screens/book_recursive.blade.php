@php
    use App\ViewModels\Menu\Object\MenuRecursiveObject;
    /**
    * @var MenuRecursiveObject $menuRecursiveObject
 * @var $show
     */
@endphp
@if($menuRecursiveObject->getId()!=-1)
    <div class="accordion-item active border rounded-0 mb-3">
        <h2 class="accordion-header d-flex align-items-center">
            <button type="button" class="accordion-button bg-light rounded-0 @if(!$show) collapsed @endif" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-{{$menuRecursiveObject->getId()}}"
                    aria-expanded="false">

               <span class="text-dark fw-bold">
                   <i class="bx bx-bar-chart-alt-2 me-2"></i> {{$menuRecursiveObject->getName()}}
               </span>
            </button>
        </h2>

        <div id="accordionWithIcon-{{$menuRecursiveObject->getId()}}"
             class="accordion-collapse collapse @if($show)show @endif">
            <div class="accordion-body mt-3">
                <div class="row">
                    @foreach($menuRecursiveObject->getBooks() as $book)
                        <div class="col-md-3 col-12 mb-2">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{$book->getThumbnail()}}" class="w-100">
                                </div>
                                <div class="col-md-10">
                                    <div class="fw-bold">{{$book->getName()}}</div>
                                    <div class="">
                                        <a href="{{$book->getLink()}}">Xem</a> |
                                        @if(principal()->hasAdvanceModify())
                                            <a href="{{route("books.show",$book->getId())}}">Sửa</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($menuRecursiveObject->getChildren()!=[])
                    @foreach($menuRecursiveObject->getChildren() as $menu)
                        @include("admin.screens.book_recursive",["menuRecursiveObject"=>$menu,"show"=>false])
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@else
    @if($menuRecursiveObject->getChildren()!=[])
        @foreach($menuRecursiveObject->getChildren() as $menu)
            @include("admin.screens.book_recursive",["menuRecursiveObject"=>$menu,'show'=>true])
        @endforeach
    @endif
@endif


