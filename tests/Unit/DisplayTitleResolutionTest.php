<?php

namespace Tests\Unit;

use App\Http\Controllers\HomeController;
use Tests\TestCase;

class DisplayTitleResolutionTest extends TestCase
{
    public function test_generic_placeholder_titles_fall_back_to_slug(): void
    {
        $controller = new HomeController();
        $method = new \ReflectionMethod($controller, 'resolveDisplayTitle');
        $method->setAccessible(true);

        $result = $method->invoke(
            $controller,
            'Admit Card Details',
            null,
            null,
            null,
            'up-police-constable-recruitment-2025-exam-city-and-admit-card-details-released',
            'Admit Card Details'
        );

        $this->assertSame('Up Police Constable Recruitment 2025 Exam City And Admit Card Details Released', $result);
    }
}
