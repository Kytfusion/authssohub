<?php

namespace Database\Factories;

use App\Mapping\OptionsMapping;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            ['type' => OptionsMapping::OPTION0, 'value' => 'Fiction', 'order' => 1, 'metadata' => json_encode(['📚']), 'description' => 'Fictional literature'],
            ['type' => OptionsMapping::OPTION0, 'value' => 'Non-Fiction', 'order' => 2, 'metadata' => json_encode(['📖']), 'description' => 'Non-fictional literature'],
            ['type' => OptionsMapping::OPTION0, 'value' => 'Science Fiction', 'order' => 3, 'metadata' => json_encode(['🚀']), 'description' => 'Sci-fi books'],
            ['type' => OptionsMapping::OPTION0, 'value' => 'Romance', 'order' => 4, 'metadata' => json_encode(['❤️']), 'description' => 'Romance novels'],
            ['type' => OptionsMapping::OPTION0, 'value' => 'Mystery', 'order' => 5, 'metadata' => json_encode(['🔍']), 'description' => 'Mystery books'],

            ['type' => OptionsMapping::OPTION1, 'value' => 'Vegetarian', 'order' => 1, 'metadata' => json_encode(['🥗']), 'description' => 'Plant-based diet'],
            ['type' => OptionsMapping::OPTION1, 'value' => 'Vegan', 'order' => 2, 'metadata' => json_encode(['🌱']), 'description' => 'Strict plant-based diet'],
            ['type' => OptionsMapping::OPTION1, 'value' => 'Pescatarian', 'order' => 3, 'metadata' => json_encode(['🐟']), 'description' => 'Fish and plant-based diet'],
            ['type' => OptionsMapping::OPTION1, 'value' => 'Omnivore', 'order' => 4, 'metadata' => json_encode(['🍖']), 'description' => 'All food types'],
            ['type' => OptionsMapping::OPTION1, 'value' => 'Gluten-Free', 'order' => 5, 'metadata' => json_encode(['🌾']), 'description' => 'No gluten diet'],

            ['type' => OptionsMapping::OPTION2, 'value' => 'High School', 'order' => 1, 'metadata' => json_encode(['🎓']), 'description' => 'High school education'],
            ['type' => OptionsMapping::OPTION2, 'value' => 'Bachelor\'s Degree', 'order' => 2, 'metadata' => json_encode(['🎓']), 'description' => 'Undergraduate degree'],
            ['type' => OptionsMapping::OPTION2, 'value' => 'Master\'s Degree', 'order' => 3, 'metadata' => json_encode(['🎓']), 'description' => 'Graduate degree'],
            ['type' => OptionsMapping::OPTION2, 'value' => 'PhD', 'order' => 4, 'metadata' => json_encode(['🎓']), 'description' => 'Doctoral degree'],
            ['type' => OptionsMapping::OPTION2, 'value' => 'Trade School', 'order' => 5, 'metadata' => json_encode(['🔧']), 'description' => 'Vocational training'],

            ['type' => OptionsMapping::OPTION3, 'value' => 'Social Drinker', 'order' => 1, 'metadata' => json_encode(['🍷']), 'description' => 'Drinks in social settings'],
            ['type' => OptionsMapping::OPTION3, 'value' => 'Non-Drinker', 'order' => 2, 'metadata' => json_encode(['🚫']), 'description' => 'Does not drink'],
            ['type' => OptionsMapping::OPTION3, 'value' => 'Occasional Drinker', 'order' => 3, 'metadata' => json_encode(['🍺']), 'description' => 'Drinks occasionally'],
            ['type' => OptionsMapping::OPTION3, 'value' => 'Regular Drinker', 'order' => 4, 'metadata' => json_encode(['🥂']), 'description' => 'Regular alcohol consumption'],

            ['type' => OptionsMapping::OPTION4, 'value' => 'Want Children', 'order' => 1, 'metadata' => json_encode(['👶']), 'description' => 'Planning to have children'],
            ['type' => OptionsMapping::OPTION4, 'value' => 'Don\'t Want Children', 'order' => 2, 'metadata' => json_encode(['🚫']), 'description' => 'No children planned'],
            ['type' => OptionsMapping::OPTION4, 'value' => 'Have Children', 'order' => 3, 'metadata' => json_encode(['👨‍👩‍👧‍👦']), 'description' => 'Already has children'],
            ['type' => OptionsMapping::OPTION4, 'value' => 'Not Sure', 'order' => 4, 'metadata' => json_encode(['❓']), 'description' => 'Undecided about children'],

            ['type' => OptionsMapping::OPTION5, 'value' => 'Sports', 'order' => 1, 'metadata' => json_encode(['⚽']), 'description' => 'Sports activities'],
            ['type' => OptionsMapping::OPTION5, 'value' => 'Art', 'order' => 2, 'metadata' => json_encode(['🎨']), 'description' => 'Artistic activities'],
            ['type' => OptionsMapping::OPTION5, 'value' => 'Music', 'order' => 3, 'metadata' => json_encode(['🎵']), 'description' => 'Musical interests'],
            ['type' => OptionsMapping::OPTION5, 'value' => 'Travel', 'order' => 4, 'metadata' => json_encode(['✈️']), 'description' => 'Travel enthusiast'],
            ['type' => OptionsMapping::OPTION5, 'value' => 'Cooking', 'order' => 5, 'metadata' => json_encode(['👨‍🍳']), 'description' => 'Culinary interests'],

            ['type' => OptionsMapping::OPTION6, 'value' => 'Romantic', 'order' => 1, 'metadata' => json_encode(['💝']), 'description' => 'Romantic and passionate'],
            ['type' => OptionsMapping::OPTION6, 'value' => 'Practical', 'order' => 2, 'metadata' => json_encode(['💡']), 'description' => 'Practical approach'],
            ['type' => OptionsMapping::OPTION6, 'value' => 'Adventurous', 'order' => 3, 'metadata' => json_encode(['🌍']), 'description' => 'Adventure seeker'],
            ['type' => OptionsMapping::OPTION6, 'value' => 'Traditional', 'order' => 4, 'metadata' => json_encode(['🏛️']), 'description' => 'Traditional values'],

            ['type' => OptionsMapping::OPTION7, 'value' => 'English', 'order' => 1, 'metadata' => json_encode(['🇬🇧']), 'description' => 'English language'],
            ['type' => OptionsMapping::OPTION7, 'value' => 'Spanish', 'order' => 2, 'metadata' => json_encode(['🇪🇸']), 'description' => 'Spanish language'],
            ['type' => OptionsMapping::OPTION7, 'value' => 'French', 'order' => 3, 'metadata' => json_encode(['🇫🇷']), 'description' => 'French language'],
            ['type' => OptionsMapping::OPTION7, 'value' => 'German', 'order' => 4, 'metadata' => json_encode(['🇩🇪']), 'description' => 'German language'],
            ['type' => OptionsMapping::OPTION7, 'value' => 'Italian', 'order' => 5, 'metadata' => json_encode(['🇮🇹']), 'description' => 'Italian language'],

            ['type' => OptionsMapping::OPTION8, 'value' => 'Action', 'order' => 1, 'metadata' => json_encode(['🎬']), 'description' => 'Action movies'],
            ['type' => OptionsMapping::OPTION8, 'value' => 'Comedy', 'order' => 2, 'metadata' => json_encode(['😄']), 'description' => 'Comedy films'],
            ['type' => OptionsMapping::OPTION8, 'value' => 'Drama', 'order' => 3, 'metadata' => json_encode(['🎭']), 'description' => 'Drama films'],
            ['type' => OptionsMapping::OPTION8, 'value' => 'Horror', 'order' => 4, 'metadata' => json_encode(['👻']), 'description' => 'Horror movies'],
            ['type' => OptionsMapping::OPTION8, 'value' => 'Documentary', 'order' => 5, 'metadata' => json_encode(['📽️']), 'description' => 'Documentary films'],

            ['type' => OptionsMapping::OPTION9, 'value' => 'Pop', 'order' => 1, 'metadata' => json_encode(['🎵']), 'description' => 'Pop music'],
            ['type' => OptionsMapping::OPTION9, 'value' => 'Rock', 'order' => 2, 'metadata' => json_encode(['🎸']), 'description' => 'Rock music'],
            ['type' => OptionsMapping::OPTION9, 'value' => 'Classical', 'order' => 3, 'metadata' => json_encode(['🎻']), 'description' => 'Classical music'],
            ['type' => OptionsMapping::OPTION9, 'value' => 'Jazz', 'order' => 4, 'metadata' => json_encode(['🎺']), 'description' => 'Jazz music'],
            ['type' => OptionsMapping::OPTION9, 'value' => 'Hip Hop', 'order' => 5, 'metadata' => json_encode(['🎤']), 'description' => 'Hip hop music'],

            ['type' => OptionsMapping::OPTION10, 'value' => 'Dog Lover', 'order' => 1, 'metadata' => json_encode(['🐕']), 'description' => 'Loves dogs'],
            ['type' => OptionsMapping::OPTION10, 'value' => 'Cat Lover', 'order' => 2, 'metadata' => json_encode(['🐱']), 'description' => 'Loves cats'],
            ['type' => OptionsMapping::OPTION10, 'value' => 'No Pets', 'order' => 3, 'metadata' => json_encode(['🚫']), 'description' => 'No pets'],
            ['type' => OptionsMapping::OPTION10, 'value' => 'Other Pets', 'order' => 4, 'metadata' => json_encode(['🐾']), 'description' => 'Other pets'],

            ['type' => OptionsMapping::OPTION11, 'value' => 'Long Term', 'order' => 1, 'metadata' => json_encode(['💑']), 'description' => 'Looking for long-term relationship'],
            ['type' => OptionsMapping::OPTION11, 'value' => 'Casual', 'order' => 2, 'metadata' => json_encode(['😊']), 'description' => 'Casual dating'],
            ['type' => OptionsMapping::OPTION11, 'value' => 'Friendship', 'order' => 3, 'metadata' => json_encode(['🤝']), 'description' => 'Looking for friendship'],
            ['type' => OptionsMapping::OPTION11, 'value' => 'Not Sure', 'order' => 4, 'metadata' => json_encode(['❓']), 'description' => 'Undecided about relationship goals'],

            ['type' => OptionsMapping::OPTION12, 'value' => 'Christian', 'order' => 1, 'metadata' => json_encode(['✝️']), 'description' => 'Christian faith'],
            ['type' => OptionsMapping::OPTION12, 'value' => 'Muslim', 'order' => 2, 'metadata' => json_encode(['☪️']), 'description' => 'Muslim faith'],
            ['type' => OptionsMapping::OPTION12, 'value' => 'Jewish', 'order' => 3, 'metadata' => json_encode(['✡️']), 'description' => 'Jewish faith'],
            ['type' => OptionsMapping::OPTION12, 'value' => 'Buddhist', 'order' => 4, 'metadata' => json_encode(['☸️']), 'description' => 'Buddhist faith'],
            ['type' => OptionsMapping::OPTION12, 'value' => 'Atheist', 'order' => 5, 'metadata' => json_encode(['🚫']), 'description' => 'No religious affiliation'],

            ['type' => OptionsMapping::OPTION13, 'value' => 'Early Bird', 'order' => 1, 'metadata' => json_encode(['🌅']), 'description' => 'Wakes up early'],
            ['type' => OptionsMapping::OPTION13, 'value' => 'Night Owl', 'order' => 2, 'metadata' => json_encode(['🌙']), 'description' => 'Stays up late'],
            ['type' => OptionsMapping::OPTION13, 'value' => 'Regular', 'order' => 3, 'metadata' => json_encode(['😴']), 'description' => 'Regular sleep schedule'],

            ['type' => OptionsMapping::OPTION14, 'value' => 'Non-Smoker', 'order' => 1, 'metadata' => json_encode(['🚫']), 'description' => 'Does not smoke'],
            ['type' => OptionsMapping::OPTION14, 'value' => 'Social Smoker', 'order' => 2, 'metadata' => json_encode(['🚬']), 'description' => 'Smokes socially'],
            ['type' => OptionsMapping::OPTION14, 'value' => 'Regular Smoker', 'order' => 3, 'metadata' => json_encode(['🚬']), 'description' => 'Regular smoker'],

            ['type' => OptionsMapping::OPTION15, 'value' => 'Active', 'order' => 1, 'metadata' => json_encode(['📱']), 'description' => 'Active on social media'],
            ['type' => OptionsMapping::OPTION15, 'value' => 'Minimal', 'order' => 2, 'metadata' => json_encode(['📱']), 'description' => 'Limited social media use'],
            ['type' => OptionsMapping::OPTION15, 'value' => 'None', 'order' => 3, 'metadata' => json_encode(['🚫']), 'description' => 'No social media presence'],

            ['type' => OptionsMapping::OPTION16, 'value' => 'Adventure', 'order' => 1, 'metadata' => json_encode(['🏔️']), 'description' => 'Adventure travel'],
            ['type' => OptionsMapping::OPTION16, 'value' => 'Relaxation', 'order' => 2, 'metadata' => json_encode(['🏖️']), 'description' => 'Relaxing vacations'],
            ['type' => OptionsMapping::OPTION16, 'value' => 'Cultural', 'order' => 3, 'metadata' => json_encode(['🏛️']), 'description' => 'Cultural experiences'],
            ['type' => OptionsMapping::OPTION16, 'value' => 'Urban', 'order' => 4, 'metadata' => json_encode(['🌆']), 'description' => 'City exploration'],

            ['type' => OptionsMapping::OPTION17, 'value' => 'Regular', 'order' => 1, 'metadata' => json_encode(['💪']), 'description' => 'Regular exercise'],
            ['type' => OptionsMapping::OPTION17, 'value' => 'Occasional', 'order' => 2, 'metadata' => json_encode(['🏃']), 'description' => 'Occasional exercise'],
            ['type' => OptionsMapping::OPTION17, 'value' => 'None', 'order' => 3, 'metadata' => json_encode(['🚫']), 'description' => 'No exercise routine'],

            ['type' => OptionsMapping::OPTION18, 'value' => 'Aries', 'order' => 1, 'metadata' => json_encode(['♈']), 'description' => 'Aries zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Taurus', 'order' => 2, 'metadata' => json_encode(['♉']), 'description' => 'Taurus zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Gemini', 'order' => 3, 'metadata' => json_encode(['♊']), 'description' => 'Gemini zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Cancer', 'order' => 4, 'metadata' => json_encode(['♋']), 'description' => 'Cancer zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Leo', 'order' => 5, 'metadata' => json_encode(['♌']), 'description' => 'Leo zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Virgo', 'order' => 6, 'metadata' => json_encode(['♍']), 'description' => 'Virgo zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Libra', 'order' => 7, 'metadata' => json_encode(['♎']), 'description' => 'Libra zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Scorpio', 'order' => 8, 'metadata' => json_encode(['♏']), 'description' => 'Scorpio zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Sagittarius', 'order' => 9, 'metadata' => json_encode(['♐']), 'description' => 'Sagittarius zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Capricorn', 'order' => 10, 'metadata' => json_encode(['♑']), 'description' => 'Capricorn zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Aquarius', 'order' => 11, 'metadata' => json_encode(['♒']), 'description' => 'Aquarius zodiac sign'],
            ['type' => OptionsMapping::OPTION18, 'value' => 'Pisces', 'order' => 12, 'metadata' => json_encode(['♓']), 'description' => 'Pisces zodiac sign']
        ];
    }
}
