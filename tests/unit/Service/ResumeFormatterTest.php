<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\DTO\ResumeDTO;
use App\DTO\UserDTO;
use App\Service\ResumeFormatter;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Monolog\Logger;

/**
 * @group formatter
 */
class ResumeFormatterTest extends Unit
{
    /**
     * @1test
     * @throws \Exception
     */
    public function givenErrorsWhenFormatErrorsReturnUniqueErrors(): void
    {
        $logger = $this->make(Logger::class, [
            'error' => Expected::never()
        ]);
        $formatter = new ResumeFormatter($logger);

        $resumeDTO = (new ResumeDTO())->setErrors(
            ['Not Found', 'Not Found']
        );

        $expected = ['Not Found'];

        $result = $formatter->formatErrors($resumeDTO);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function givenIncorrectResumeDTOWhenFormatThenReturnErrorOnly(): void
    {
        $user = (new UserDTO())
            ->setLocation('Los Angeles, California')
            ->setName('Howel Thomas')
            ->setWebsite('http://example.com')
            ->setLogin('mxcl');
        $resumeDTO = (new ResumeDTO())
            ->setUser($user)
           ;

        $logger = $this->make(Logger::class, [
            'error' => Expected::once()
        ]);
        $formatter = new ResumeFormatter($logger);

        $expected = ['error' => 'Data could not be formatted'];

        $result = $formatter->format($resumeDTO);

        $this->assertEquals($expected, $result);
    }
}
