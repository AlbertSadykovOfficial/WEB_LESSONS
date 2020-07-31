<?php  
/*
// --- Округление
			double round(double $val, [, int $precision = 0 [, int mode = PHP_ROUND_HALF_UP]])
				2 Параметр - до какого знака
					$foo = round(l23.256, 2); // $foo = 123.26 
					$foo = round(l27.256, -2); // $foo = 100.0 

					mode
					PHP_ROUND_HALF_UP - округление середины (0.5) В большую сторону 3.5 -> 4, -3.5 -> -4
					PHP_ROUND_HALF_DOWN - округление середины (0.5) В меньшую сторону 3.5 -> 3, -3.5 -> -3
					PHP_ROUND_HALF_EVEN - округление (0.5) до ближайшего четного
					PHP_ROUND_HALF -ODD - округление (0.5) до ближайшего нечетного

			int ceil($x) - Округление в обльшую сторону
			int floor($x) - Округление в меньшую сторону

// --- Слуайные числа
			Про rand() - стоит забыть, он никуда не годится
			
			1) int mt_rand(int $min = 0, int $max= RAND_MAX) // mt_getrandmax ()- УЗНАТЬ RAND_MAX
			2) void mt_srand(int $seed) // Настраивает mt_rand, если кинуть туда одно и тоже число, то последовательность будет предсказуема
			3) int random_int(int $min = PHP_INT_MIN, int $max= PHP_INT_MAX) 
*/

/*
			Перевод в системы исчисления
			string base_convert(string $number, int $franbase, int $tabase) 
			echo base_convert ("FF", 16, 2);  // 1111 1111 

			int bindec (string $num_string) 
			int octdec(string $num_string) 
			int haxdec(string $num_string) 

			string decbin (int $number) 
			string decoct (int $number) 
			string dechex (int $number) 
*/

/*
			Min Max (первым аргументом модно кидать массив)
			mixad min (mixed $arg1 [mixed $arg2, ..., I mixed $argn]) 
			mixad min (mixed $arg1 [mixed $arg2, ..., I mixed $argn]) 
*/

/*
			Не Числа
			NAN - это число
			bool is_nan(mixed $variable);
			bool is_muneric() - вернет TRUE на NAN
			bool is_ infinite (mixad $variable) - Проверка на бесконечность
*/

/*
			Степенные Функции
			float sqrt(float $arg) 
			float log(float $arg) 
			float exp(float $arg)
			float pow (float $base, float $exp)
*/
/*
			Тригонометрия

			float deg2rad(float $deg) // Градусы в радианы = $deg/180*M_PI. 
			float rad2deg(float $deg) 
			float acos(float $arg)   // arccos
			float asin(float $arg) 
			float atan(float $arg)
			float atan2(float $y, float $x) // arctg(y/x) с учетом четверти xy (вернет радианы)

*/
?>