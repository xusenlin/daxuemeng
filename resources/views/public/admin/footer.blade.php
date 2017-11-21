<!--全局的底部-->
<!-- VUE -->
<script src="{{ asset('Element/vue.js') }}"></script>
<!-- Element UI -->
<script src="{{ asset('Element/index.js') }}"></script>
<!-- jQuery 2.2.3 -->
<script src="{{ asset('AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js') }}"></script>

<script src="{{ asset('Backend/js/public.js') }}"></script>
<script>
    Vue.prototype.ajax = function (type,url, data,fnSucc,app) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type : type,
            url : url,
            data : data,
            success : function(result) {
                if (result.ok){
                    fnSucc(result.data);
                }else {
                    app.$notify.error({
                        title: '错误',
                        message: result.errorMsg
                    });
                }
            },
            error : function (XMLHttpRequest, textStatus, errorThrown) {
                app.$notify.error({
                    title: '错误',
                    message: '错误状态码:'+XMLHttpRequest.status
                });
            }
        });
    };
</script>
@yield('js')

</body>
</html>