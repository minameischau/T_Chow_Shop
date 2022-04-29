<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="exampleModalLabel">Chắc chắn muốn thoát ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Chọn "Đồng ý" để thoát khỏi phiên làm việc.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary rounded-pill" type="button" data-dismiss="modal">Hủy</button>
                <a class="btn btn-primary rounded-pill" href="../login.php">Đồng ý</a>
            </div>
        </div>
    </div>
</div>
<!-- End logout Modal-->