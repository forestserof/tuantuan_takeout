$(document).ready(function() {
    // 监听数量按钮的点击事件
    $('.quantity-button').click(function() {
      // 获取商品ID和数量变化值
      var id = $(this).data('id');
      var quantityChange = $(this).data('quantity-change');

      // 发送AJAX请求到update_quantity.php
      $.ajax({
        url: '../php/update_quantity.php',
        method: 'POST',
        data: {
          id: id,
          quantityChange: quantityChange
        },
        success: function(response) {
          // 更新页面上的数量显示
          var quantitySpan = $('#quantity-' + id);
          quantitySpan.text(response);
        }
      });
    });

    // 监听删除按钮的点击事件
    $('.delete-button').click(function() {
      // 获取商品ID
      var id = $(this).data('id');

      // 发送AJAX请求到delete_item.php
      $.ajax({
        url: '../php/delete_item.php',
        method: 'POST',
        data: {
          id: id
        },
        success: function() {
          // 刷新页面
          location.reload();
        }
      });
    });
  });