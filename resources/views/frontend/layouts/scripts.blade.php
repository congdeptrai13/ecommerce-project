<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".shopping-cart-form").on("submit", function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                method: "POST",
                data: formData,
                url: "{{ route('add-to-cart') }}",
                success: function(data) {
                    if (data.status === "success") {

                        updateCartCount();
                        fetchCartContent();
                        fetchMiniCartAmount();
                        $(".mini_cart_actions").removeClass("d-none");
                        toastr.success(data.message);
                    } else if (data.status === "stock_out") {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {

                }
            })
        })

        function updateCartCount() {
            $.ajax({
                method: "GET",
                url: "{{ route('cart-count') }}",
                success: function(data) {
                    $("#cart-count").text(data);
                },
                error: function(data) {

                }
            })
        }

        function fetchCartContent() {
            $.ajax({
                type: 'GET',
                url: "{{ route('cart-content') }}",
                success: function(data) {
                    $(".mini_cart_wrapper").html("");
                    let html = "";
                    for (let item in data) {
                        let product = data[item];
                        var totalPrice = (product.price + product.options.variants_total) * product
                            .qty;
                        html += `
                                        <li id="mini_cart_${product.rowId}">
                                            <div class="wsus__cart_img">
                                                <a href="#"><img src="{{ asset('/') }}${product.options.image} " alt="product"
                                                        class="img-fluid w-70"></a>
                                                <a class="wsis__del_icon remove_sidebar_product" href="#"
                                                    data-rowId="${product.rowId}"><i class="fas fa-minus-circle"></i></a>
                                            </div>
                                            <div class="wsus__cart_text">
                                                <a class="wsus__cart_title"
                                                    href="${product.options.slug}">${product.name}</a>
                                                <p>{{ $settings->currency_icon }}${totalPrice}
                                                </p>
                                            </div>
                                        </li>
                                        `;
                    }
                    $('.mini_cart_wrapper').html(html);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(error);
                }
            })
        }

        $("body").on("click", ".remove_sidebar_product", function(e) {
            e.preventDefault();
            let rowId = $(this).data('rowid');
            $.ajax({
                type: 'POST',
                url: "{{ route('mini-cart-remove') }}",
                data: {
                    rowId: rowId
                },
                success: function(data) {
                    let cartId = "#mini_cart_" + rowId;
                    $(cartId).remove();
                    fetchMiniCartAmount();
                    if ($(".mini_cart_wrapper").find("li").length === 0) {
                        $(".mini_cart_actions").addClass("d-none");
                        $(".mini_cart_wrapper").html(
                            "<p class='text-center'>Mini cart Empty</p>");
                    }
                    toastr.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(error);
                }
            })
        })


        //fetch amount mini cart
        function fetchMiniCartAmount() {
            $.ajax({
                type: 'GET',
                url: "{{ route('mini-cart-amount') }}",
                success: function(data) {
                    console.log(data);
                    $(".mini-cart-amount").text(
                        `{{ $settings->currency_icon }}${data}`);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(error);
                }
            })
        }
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // clear cart
            $(".clear-cart").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: "{{ route('clear-cart') }}",
                            success: function(data) {
                                if (data.status === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        data.message,
                                        'success'
                                    )
                                    window.location.reload();
                                } else if (data.status === 'error') {
                                    Swal.fire(
                                        'Cant Delete!',
                                        data.message,
                                        'error'
                                    )
                                    //window.location.reload();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(error);
                            }
                        })
                    }
                })
            })

        })

        $(".button-increment").click(function() {
            let input = $(this).siblings(".input-qty-cart");
            let rowId = input.data("rowid");
            let quantity = parseInt(input.val()) + 1;
            input.val(quantity);
            $.ajax({
                url: "{{ route('update-product-quantity') }}",
                method: "POST",
                data: {
                    rowId: rowId,
                    quantity: quantity
                },
                success: function(data) {
                    // Xử lý khi request thành công
                    if (data.status === "success") {
                        let productId = "#" + rowId;
                        let totalAmount = "{{ $settings->currency_icon }}" + data
                            .product_total
                        $(productId).text(totalAmount);
                        fetchAmountInCartDetail();
                        toastr.success(data.message);
                    } else if (data.status === "stock_out") {
                        toastr.error(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý khi có lỗi
                }
            });
        })

        $(".button-decrement").click(function() {
            let input = $(this).siblings(".input-qty-cart");
            let rowId = input.data("rowid");
            let quantity = parseInt(input.val()) - 1;
            input.val(quantity);
            $.ajax({
                url: "{{ route('update-product-quantity') }}",
                method: "POST",
                data: {
                    rowId: rowId,
                    quantity: quantity
                },
                success: function(data) {
                    // Xử lý khi request thành công
                    if (data.status === "success") {

                        let productId = "#" + rowId;
                        let totalAmount = "{{ $settings->currency_icon }}" + data
                            .product_total
                        $(productId).text(totalAmount);
                        fetchAmountInCartDetail();
                        toastr.success(data.message);
                    } else if (data.status === "stock_out") {
                        toastr.error(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý khi có lỗi
                }
            });
        })

        // clear cart
        $(".clear-cart").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('clear-cart') }}",
                        success: function(data) {
                            if (data.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                )
                                window.location.reload();
                            } else if (data.status === 'error') {
                                Swal.fire(
                                    'Cant Delete!',
                                    data.message,
                                    'error'
                                )
                                //window.location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            console.log(error);
                        }
                    })
                }
            })
        })

        //fetch subtotal in cart-detail
        function fetchAmountInCartDetail() {
            $.ajax({
                type: 'GET',
                url: "{{ route('mini-cart-amount') }}",
                success: function(data) {
                    $("#sub_total_cart").text(
                        `{{ $settings->currency_icon }}${data}`);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(error);
                }
            })
        }

    })
</script>
