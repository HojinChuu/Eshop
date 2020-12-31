<div class="modal fade" id="chargeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= URLROOT ?>/users/moneyCharge/<?= $_SESSION["user_id"] ?>" method="post">
                <div class="modal-body input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">￥</span>
                    </div>
                    <input type="number" name="money" class="form-control" required />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <input type="submit" value="CHARGE" class="btn btn-outline-dark" />
                </div>
            </form>
        </div>
    </div>
</div>