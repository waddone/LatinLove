<form class="form-horizontal" method="POST" action="{{ route('test-mail-post') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input name="title" value><br/>
                        <textarea name="description"></textarea>
                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Add dance style
                                </button>
                            </div>
                        </div>
                        <br/>
                    </form>