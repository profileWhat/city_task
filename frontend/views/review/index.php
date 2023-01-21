<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$reviews = $dataProvider->getModels();

$this->title = 'Reviews';
$this->params['breadcrumbs'][] = $this->title;

/** Element for upload bootstrap for Select2 */
Select2::widget([
    'name' => 'hide',
    'options' => ['placeholder' => 'Select a city ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>

    <div class="review-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::button('Create Review', ['class' => 'btn btn-success', 'id' => 'createBtn']) ?>
        </p>

        <div id="createReview">
        </div>


        <div id="stopCreate">
            <?= Html::button('Stop creating', ['class' => 'btn btn-danger', 'id' => 'stopCreateBtn', 'style' => 'display: none']) ?>
        </div>
        <div id="reviews">
            <?php foreach ($reviews as $review): ?>
                <div id="review-view_<?= $review->id ?>">
                    <div id="review_<?= $review->id ?>">
                        <?= \common\widgets\Review::widget(['review' => $review]) ?>
                    </div>
                    <update-button class="btn btn-success" id="update-start_<?= $review->id ?>"
                                   data-id="<?= $review->id ?>">
                        Update
                    </update-button>
                    <delete-button class="btn btn-danger" id="delete_<?= $review->id ?>"
                                   data-id="<?= $review->id ?>">
                        Delete
                    </delete-button>
                    <update-form id="update_<?= $review->id ?>">
                    </update-form>
                    <update-cancel-button class="btn btn-danger" style="display: none"
                                          id="update-cancel_<?= $review->id ?>"
                                          data-id="<?= $review->id ?>">
                        Cancel updating
                    </update-cancel-button>
                </div>
            <?php endforeach; ?>
        </div>
        <?php echo LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]); ?>
    </div>

<?php
$js = <<<JS
    function setCancelButtons() {
        $('update-cancel-button').each(function (index, element) {
            let review_id = element.dataset.id
            element.onclick = function () {
                element.style.display = 'none';
                $('#update-start_' + review_id).show();
                $('#delete_' + review_id).show();
                $('#update_' + review_id).html("");
                $('#review_' + review_id).show();
            }
        });
    }
    
    function setUpdateButtons() {
        $('update-button').each(function (index, element) {
            let review_id = element.dataset.id
            element.onclick = function () {
               stopCreate();
               stopUpdate();
                $.ajax({
                    url: '/review/update?id=' + review_id,
                    type: 'POST',
                    success: function(res){
                        element.style.display = 'none';
                        $('#delete_' + review_id).hide();
                        $('#review_' + review_id).hide();
                        $('#update-cancel_' + review_id).show();
                        $('#update_' + review_id).html(res);
                        $('#review-create-form').on('beforeSubmit', function (e) {
                        updateReview($(this), review_id);
	                    return false;
                    });
                    },
                    error: function() {
                        alert('Cannot update review!');
                    }
                });
            }
        });
    }
    
    function setDeleteButtons() {
    $('delete-button').each(function (index, element) {
            let review_id = element.dataset.id
            element.onclick = function () {
                alert("Review will be deleted");
                $.ajax({
                    url: '/review/delete?id=' + review_id,
                    type: 'POST',
                    success: function(res){
                        $('#review-view_' + review_id).html("");
                        if (!res) alert('Cannot delete review!'); 
                    },
                    error: function() {
                        alert('Cannot delete review!');
                    }
                });
            }
        });
    }
    
    setCancelButtons();
    setUpdateButtons();
    setDeleteButtons();
    function stopUpdate() {
        $('update-cancel-button').each(function (index, element) {
           element.click(); 
        });
    }

    function updateReview(form, id) {
        $.ajax({
            url: '/review/update?id=' + id,
            type: 'POST',
            data: form.serialize(),
            success: function(res){
                console.log(res);
                let review = document.getElementById('review_' + id);
                review.innerHTML = res;
                stopUpdate();
            },
            error: function() {
                alert('Cannot update review!');
            }
           });
    }
    
    function stopCreate() {
        $('#createReview').html("");
        $('#createBtn').show();
        $('#stopCreateBtn').hide();
    }
    
    $('#stopCreateBtn').click(stopCreate);

    function insert(reviewHtml) {
        var div = document.createElement('div');
        div.innerHTML = reviewHtml.trim();
        let review = div.getElementsByClassName("review-view");
        let review_id = review.item(0).dataset.id;
                
        let reviews = document.getElementById('reviews');
        reviews.insertAdjacentHTML('afterbegin', 
                "<update-button class='btn btn-success' id='update-start_" + review_id  + "' data-id='" + review_id + "'>" +
                    "Update" +
                "</update-button>" +
                "<delete-button class='btn btn-danger' id='delete_" + review_id + "' data-id='" + review_id + "'>" +
                    "Delete" +
                "</delete-button>" +
                "<update-form id='update_" + review_id + "'>" +
                "</update-form>" +
                "<update-cancel-button class='btn btn-danger' style='display: none' id='update-cancel_" + review_id + "' data-id='" + review_id +"'>" +
                    "Cancel updating" +
                "</update-cancel-button>");
        setCancelButtons();
        setUpdateButtons();
        setDeleteButtons();
        reviews.insertAdjacentHTML('afterbegin', 
                "<div id='review_" + review_id + "'>" +
                reviewHtml + 
                "</div>");
    }
    
    function createReview(form) {
        $.ajax({
            url: '/review/create',
            type: 'POST',
            data: form.serialize(),
            success: function(res){
                insert(res);
                stopCreate();
            },
            error: function() {
                alert('Cannot create review!');
            }
           });
    }
    
    $("#createBtn").click(function () {
        $.ajax({
            url: '/review/create',
            type: 'POST',
            success: function(res){
                $("#createReview").html(res);
                $('#review-create-form').on('beforeSubmit', function (e) {
                    createReview($(this));
	                return false;
                });
                $('#createReview').show();
                $("#createBtn").hide();
                $("#stopCreateBtn").show();
            },
            error: function(){
                alert('Cannot create review!');
            }
        });
    })
JS;
$this->registerJs($js);
?>