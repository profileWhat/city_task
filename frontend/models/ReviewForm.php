<?php

namespace frontend\models;

use common\models\City;
use common\models\CityReview;
use common\models\Review;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ReviewForm extends Model
{
    public $title;
    public $text;
    public $rating;
    public $img;
    public $citiesId = [];
    public $cities;
    private Review $review;

    public function __construct($config = [])
    {
        $this->review = new Review();
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text', 'rating'], 'required'],
            [['img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            ['text', 'string', 'max' => 255],
            ['title', 'string', 'max' => 100],
            [['rating'], 'integer', 'min' => 1, 'max' => 5],
            ['citiesId', 'each', 'rule' => ['integer']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'text' => 'Text',
            'rating' => 'Rating',
            'img' => 'Img',
            'citiesId' => 'City',
        ];
    }

    /**
     * Save Review model with city relations
     *
     * @return bool
     */
    public function saveReview()
    {
        $this->review->title = $this->title;
        $this->review->text = $this->text;
        $this->review->rating = $this->rating;
        $this->review->img = $this->img;
        if (!$this->review->save()) return false;
        if ($this->citiesId != null) {

            for ($i = 0; $i < count($this->citiesId); $i++) {
                $city = City::findOne(['id' => $this->citiesId[$i]]);
                $cityReview = new CityReview();
                $cityReview->city_id = $city->id;
                $cityReview->review_id = $this->review->id;
                $cityReview->save();
            }
        }
        return true;
    }

    /**
     * Load Review values into reviewForm
     *
     * @param Review $review
     */
    public function loadDefaultValues(Review $review)
    {
        $this->review = $review;
        $this->title = $review->title;
        $this->text = $review->text;
        $this->rating = $review->rating;
        $this->cities = ArrayHelper::map($review->cities, 'id', 'id');
    }

    /**
     * @return Review
     */
    public function getReview(): Review
    {
        return $this->review;
    }
}