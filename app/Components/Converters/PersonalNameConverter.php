<?php

namespace Adapta\Components\Converters;

class PersonalNameConverter
{
    public function __invoke($input)
    {
        return $this->getPartsFromFullName($input);
    }

    private function getPartsFromFullName($full_name)
    {
        $fname = '';
        $lname = '';
        $initials = '';
        $name_parts = [
            'original' => $full_name,
        ];

        $full_name = trim($full_name);

        if (strlen($full_name)) {
            $full_name = preg_replace('/(Assoc\.?(iate)? |\/)Prof(essor)?\.?/i', 'Assoc_Prof', $full_name);

            $full_name = str_replace(',', '', $full_name);

// split into words
            $unfiltered_name_parts = explode(' ', $full_name);
// completely ignore any words in parentheses
            foreach ($unfiltered_name_parts as $word) {
                if (@$word{0} != '(') {
                    $name_parts[] = $word;
                }
            }
            $num_words = sizeof($name_parts);

            if (!$num_words) {
                return [];
            }

// is the first word a title? (Mr. Mrs, etc)
            $salutation = self::is_salutation($name_parts[0]);
            $suffix = self::is_suffix($name_parts[sizeof($name_parts) - 1]);

// set the range for the middle part of the name (trim prefixes & suffixes)
            $start = ($salutation) ? 1 : 0;
            $end = ($suffix) ? $num_words - 1 : $num_words;

// concat the first name
            for ($i = $start; $i < $end - 1; ++$i) {
                $word = $name_parts[$i];
// move on to parsing the last name if we find an indicator of a compound last name (Von, Van, etc)
// we use $i != $start to allow for rare cases where an indicaator is actually the first name (like "Von Fabella")
                if (self::is_compound_lname($word) && $i != $start) {
                    break;
                }
// is it a middle initial or part of their first name?
// if we start off with an initial, we'll call it the first name
                if (self::is_initial($word)) {
                    // is the initial the first word?  
                    if ($i == $start) {
                        // if so, do a look-ahead to see if they go by their middle name
// for ex: "R. Jason Smith" => "Jason Smith" & "R." is stored as an initial
// but "R. J. Smith" => "R. Smith" and "J." is stored as an initial
                        if (self::is_initial($name_parts[$i + 1])) {
                            $fname .= ' '.strtoupper($word);
                        } else {
                            $initials .= ' '.strtoupper($word);
                        }
// otherwise, just go ahead and save the initial
                    } else {
                        $initials .= ' '.strtoupper($word);
                    }
                } else {
                    $fname .= ' '.self::fix_case($word);
                }
            }

// check that we have more than 1 word in our string
            if ($end - $start > 1) {
                // concat the last name
                for ($i; $i < $end; ++$i) {
                    $lname .= ' '.self::fix_case($name_parts[$i]);
                }
// $lname = self::fix_case($lname);
            } else {
                // otherwise, single word strings are assumed to be first names
                $fname = self::fix_case($name_parts[$i]);
            }

// return the various parts in an array
            $name['title'] = $salutation;
            $name['first_name'] = trim($fname);
// $name['initials'] = trim($initials);
            $name['last_name'] = trim($lname);
// $name['suffix'] = $suffix;
        } else {
            $name = ['title' => null, 'first_name' => null, 'last_name' => null];
        }

        return $name;
    }

// detect and format standard salutations
// I'm only considering english honorifics for now & not words like
    private static function is_salutation($word)
    {
        // ignore periods
        $word = str_replace('.', '', strtolower($word));
// returns normalized values
        switch ($word) {
            case 'mr':
            case 'master':
            case 'mister':
            $word = 'Mr';
            break;
            case 'mrs':
            $word = 'Mrs';
            break;
            case 'miss':
            $word = 'Miss';
            break;
            case 'ms':
            $word = 'Ms';
            break;
            case 'dr':
            case 'doctor':
            $word = 'Dr';
            break;
            case 'rev':
            case 'reverend':
            $word = 'Rev';
            break;
            case 'fr':
            case 'father':
            $word = 'Fr';
            break;
            case 'r':
            case 'rabbi':
            $word = 'Rabbi';
            break;
            case 'sr':
            case 'sister':
            $word = 'Sr';
            break;
            case 'br':
            case 'brother':
            $word = 'Br';
            break;
            case 'assoc_prof':
            case 'a/prof':
            $word = 'Assoc Prof';
            break;
            case 'prof':
            case 'professor':
            $word = 'Prof';
            break;
            default:
            $word = false;
        }

        return $word;
    }

//  detect and format common suffixes
    private static function is_suffix($word)
    {
        // ignore periods
        $word = str_replace('.', '', $word);
        if (strlen($word) > 2 && ctype_upper($word)) {
            return $word;
        }

        $misinterpret = array('Ma', 'Pe', 'Ao'); // Possible Chinese surnames which look similar to prefixes

    if (array_search($word, $misinterpret, true) !== false) {
        return false;
    }

// these are some common suffixes - what am I missing?
    $suffix_array = array('I','II','III','IV','V','Senior','Junior','Jr','Sr','Jnr','Snr','PhD','APR','RPh','PE','MD','MA','DMD','CME','AO', 'OAM', 'AM', 'AS', 'RSM');

        foreach ($suffix_array as $suffix) {
            if (strtolower($suffix) == strtolower($word)) {
                return $suffix;
            }
        }

        return false;
    }

// detect compound last names like "Von Fange"
private static function is_compound_lname($word)
{
    $word = strtolower($word);
// these are some common prefixes that identify a compound last names - what am I missing?
    $words = array('le', 'vere','von','van','de','del','della','di','da','vanden','du','st.','st','la','ter');

    return array_search($word, $words);
}

// single letter, possibly followed by a period
private static function is_initial($word)
{
    return ((strlen($word) == 1) || (strlen($word) == 2 && $word{1} == '.'));
}

// detect mixed case words like "McDonald"
// returns false if the string is all one case
private static function is_camel_case($word)
{
    if (preg_match('|[A-Z]+|s', $word) && preg_match('|[a-z]+|s', $word)) {
        return true;
    }

    return false;
}

// ucfirst words split by dashes or periods
// ucfirst all upper/lower strings, but leave camelcase words alone
private static function fix_case($word)
{
    if (self::is_compound_lname($word)) {
        return $word;
    }
// uppercase words split by dashes, like "Kimura-Fay"
    $word = self::safe_ucfirst('-', $word);
// uppercase words split by apostrophes, like "O'Leary"
    $word = self::safe_ucfirst("'", $word);
// uppercase words split by periods, like "J.P."
    $word = self::safe_ucfirst('.', $word);

    return $word;
}

// helper public function for fix_case
private static function safe_ucfirst($seperator, $word)
{
    // uppercase words split by the seperator (ex. dashes or periods)
    $parts = explode($seperator, $word);
    foreach ($parts as $word) {
        $words[] = (self::is_camel_case($word)) ? $word : ucfirst(strtolower($word));
    }

    return implode($seperator, $words);
}
}
