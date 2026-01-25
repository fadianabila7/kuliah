<?php
class TextProcessor
{
    public static function preprocessText($text)
    {
        // Ubah ke huruf kecil
        $text = strtolower($text);
        // Hilangkan tanda baca
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);
        // Tokenisasi (pisahkan kata-kata)
        $tokens = explode(' ', $text);
        return $tokens;
    }

    public static function calculateTFIDF($userTokens, $dbQuestion)
    {
        $dbTokens = self::preprocessText($dbQuestion);
        $allTokens = array_unique(array_merge($userTokens, $dbTokens));

        $tf = array_fill_keys($allTokens, 0);
        $idf = array_fill_keys($allTokens, 0);

        // Hitung TF untuk pertanyaan pengguna
        foreach ($userTokens as $token) {
            if (isset($tf[$token])) {
                $tf[$token]++;
            }
        }

        // Hitung IDF untuk database
        foreach ($allTokens as $token) {
            if (in_array($token, $dbTokens)) {
                $idf[$token] = 1;
            }
        }

        // Hitung skor TF-IDF
        $tfidf = 0;
        foreach ($allTokens as $token) {
            $tfidf += ($tf[$token] * log(1 + $idf[$token]));
        }

        return $tfidf;
    }
}
