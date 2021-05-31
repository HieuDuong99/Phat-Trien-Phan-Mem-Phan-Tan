function GET(value) {
    url = document.URL.slice(document.URL.search('\\?'));
    if (url.search(value + "=")>=0) {
        var find= url.slice(url.search(value + "="));
        find= find.slice(find.search('=')+1);
        if (find.search('&')>=0){
        find= find.substring(0, find.search('&'));}
        return decodeURIComponent(find).replace(/\+/g, ' ');
    } else {
        return "";
    }
}

function activeLink() {
    var active = GET("m");
    if (active != "") {
        $("aside .nav-link.active").removeClass('active');
        $("aside .nav-link[dataname=" + active + "]").addClass("active");
    }
}

function ajax_data(url, data) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function(result) {
            if (result == 0) {
                window.location.href = "";
            } else {
                $(".content-wrapper").remove();
                $("aside").after(result);
                history.pushState({url: url, data: data}, null, url);
            }
        },
        error: function(error) {
            
        }      
    });
}

function ajax_create(data, m, multidata = false) {
    var url = "?cn=admin&m=" + m + "&f=create";
    var contenttype = multidata? false: "application/x-www-form-urlencoded";
    var processdata = multidata? false: true;

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        contentType: contenttype,
        processData: processdata,
        success: function(result) {
            if (result == 0) {
                window.location.href = "";
            } else {
                result = JSON.parse(result);
                if (result.status == 0) {
                    $.each(result.error, function(key, value) {
                        $("#"+key).addClass('is-invalid');
                        $(".alert").remove();
                        $(".main").before('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + value + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    });
                }
                if (result.status == 2) {
                    $(".alert").remove();
                    $(".main").before('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + result.error + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
                if (result.status == 1) {
                    ajax_data("?cn=admin&m=" + m, m);
                }
            }
        },
        error: function(error) {
            
        }      
    });
}

function ajax_update(id, data, m, multidata = false) {
    var url = "?cn=admin&m=" + m + "&f=update&id=" + id;
    var contenttype = multidata? false: "application/x-www-form-urlencoded";
    var processdata = multidata? false: true;

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        contentType: contenttype,
        processData: processdata,
        success: function(result) {
            if (result == 0) {
                window.location.href = "";
            } else {
                result = JSON.parse(result);
                if (result.status == 0) {
                    $.each(result.error, function(key, value) {
                        $("#"+key).addClass('is-invalid');
                        $(".alert").remove();
                        $(".main").before('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + value + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    });
                }
                if (result.status == 2) {
                    $(".alert").remove();
                    $(".main").before('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + result.error + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
                if (result.status == 1 || result.status == 3) {
                    ajax_data("?cn=admin&m=" + m, m);
                }
            }
        },
        error: function(error) {
            
        }      
    });
}

activeLink();

$('.main-sidebar').on("show.bs.collapse", function() {
    $(this).addClass('myopen');
}).on("shown.bs.collapse", function() {
    setTimeout(function() {
        $('.main-sidebar').removeClass('myopen');
    }, 700);
}).on("hide.bs.collapse", function() {
    $(this).addClass('myclose');
    setTimeout(function() {
        $('.main-sidebar').removeClass('myclose');
    }, 700);
});

$("aside .nav-link").on("click", function() {
	$("aside .nav-link.active").removeClass('active');
	$(this).addClass("active");
    var url = $(this).attr('url');
    var data = $(this).attr('dataname');
    ajax_data(url, data);
});

var width = $(window).width();

if(width < 992) {
	$('.main-sidebar').collapse('hide');
}

window.addEventListener("resize", function() {
    if($(window).width() != width && $(window).width() < 992) {
    	$('.main-sidebar').collapse('hide');
    	width = $(window).width();
    }
    if($(window).width() != width && $(window).width() >= 992) {
    	$('.main-sidebar').collapse('show');
    	width = $(window).width();
    }
});

function ajax_state(url, data) {
    $("aside .nav-link.active").removeClass('active');
    $("aside .nav-link[dataname=" + data + "]").addClass("active");
    $.ajax({
        url: url,
        type: 'GET',
        success: function(result) {
            if (result == 0) {
                window.location.href = "";
            } else {
                $(".content-wrapper").remove();
                $("aside").after(result);
            }
        },
        error: function(error) {
            
        }      
    });
}

window.addEventListener('popstate', function(e) {
    var state = e.state;
    if (state != null) {
        ajax_state(state.url, state.data);
    } else {
        ajax_state("?cn=admin", "index");
    }  
});

//functionality functions
function updateItem(id, m) {
    var url = "?cn=admin&m=" + m + "&f=update&id=" + id;
    $.ajax({
        url: url,
        type: 'GET',
        success: function(result) {
            if (result == 0) {
                window.location.href = "";
            } else {
                if (result == 3) {
                     $("#id" + id).animate({
                        opacity: 0
                    }, 500);
                    setTimeout(function() {
                        $("#id" + id).remove();
                    }, 500);
                    $(".alert").remove();
                    $(".main-content").before('<div class="alert alert-danger alert-dismissible fade show" role="alert">Dữ liệu không tồn tại<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                } else {
                    $(".content-wrapper").remove();
                    $("aside").after(result);
                    history.pushState({url: url, data: m}, null, url);
                }
            } 
        },
        error: function(error) {
            
        }      
    });
}

function deleteItem(id, m, redir = false) {
    if (confirm("Bạn có chắc chắn xóa không?")) {
        $.ajax({
            url: "?cn=admin&m=" + m + "&f=delete&id=" + id + "&redir=" + redir,
            type: 'GET',
            success: function(result) {
                if (result == 0) {
                    window.location.href = "";
                } else {
                    if (result == 1) {
                        if (redir) {
                            ajax_data("?cn=admin&m=" + m, m);
                        } else {
                            $("#id" + id).animate({
                                opacity: 0
                            }, 500);
                            setTimeout(function() {
                                $("#id" + id).remove();
                            }, 500);
                            $(".alert").remove();
                            $(".main-content").before('<div class="alert alert-success alert-dismissible fade show" role="alert">Xóa thành công<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }
                    } else {
                        if (result == 2) {
                            $(".alert").remove();
                            $(".main-content").before('<div class="alert alert-danger alert-dismissible fade show" role="alert">Xóa thất bại<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }
                        if (result == 3) {
                            if (redir) {
                                ajax_data("?cn=admin&m=" + m, m);
                            } else {
                                $("#id" + id).animate({
                                    opacity: 0
                                }, 500);
                                setTimeout(function() {
                                    $("#id" + id).remove();
                                }, 500);
                                $(".alert").remove();
                                $(".main-content").before('<div class="alert alert-danger alert-dismissible fade show" role="alert">Dữ liệu không tồn tại<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            }
                        }
                    } 
                }
            },
            error: function(error) {
                
            }      
        });
    }
}




function detailsItem(id, m) {
    var url = "?cn=admin&m=" + m + "&f=details&id=" + id;
    $.ajax({
        url: url,
        type: 'GET',
        success: function(result) {
            if (result == 0) {
                window.location.href = "";
            } else {
                if (result == 3) {
                     $("#id" + id).animate({
                        opacity: 0
                    }, 500);
                    setTimeout(function() {
                        $("#id" + id).remove();
                    }, 500);
                    $(".alert").remove();
                    $(".main-content").before('<div class="alert alert-danger alert-dismissible fade show" role="alert">Dữ liệu không tồn tại<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                } else {
                    $(".content-wrapper").remove();
                    $("aside").after(result);
                    history.pushState({url: url, data: m}, null, url);
                }
            } 
        },
        error: function(error) {
            
        }      
    });
}

function searching(keyword, m) {
    url = "?cn=admin&m=" + m + "&keyword=" + keyword;
    ajax_data(url, m);
}

function create(m) {
    var url = "?cn=admin&m=" + m + "&f=create";
    ajax_data(url, m);
}