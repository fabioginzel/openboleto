<?php

namespace Tests\OpenBoleto\Banco;

use OpenBoleto\Banco\Santander;
use PHPUnit\Framework\TestCase;


class SantanderTest extends TestCase
{
    /**
     * @return void
     */
    public function testInstantiateWithoutArgumentsShouldWork()
    {
        $this->assertInstanceOf(\OpenBoleto\Banco\Santander::class, new Santander());
    }

    /**
     * @return void
     */
    public function testInstantiateShouldWork()
    {
        $instance = new Santander(
            array(
                // Parâmetros obrigatórios
                'dataVencimento' => new \DateTime('2013-01-01'),
                'valor' => 23.00,
                'sequencial' => 12345678901, // Até 13 dígitos
                'agencia' => 1234, // Até 4 dígitos
                'carteira' => 102, // 101, 102 ou 201
                'conta' => 1234567, // Código do cedente: Até 7 dígitos
                // IOS – Seguradoras (Se 7% informar 7. Limitado a 9%)
                // Demais clientes usar 0 (zero)
                'ios' => '0', // Apenas para o Santander
            )
        );

        $this->assertInstanceOf(\OpenBoleto\Banco\Santander::class, $instance);
        $this->assertEquals('03399.12347 56701.234561 78901.001020 2 55650000002300', $instance->getLinhaDigitavel());
        $this->assertSame('012345678901-0', (string) $instance->getNossoNumero());
    }
}
