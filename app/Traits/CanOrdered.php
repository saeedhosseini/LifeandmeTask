<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CanOrdered
{
    protected string $nameScope = 'Order';
    private string $baseName;

    public function __construct()
    {
        $this->baseName = 'scope' . $this->nameScope;
    }

    /**
     * list of name of type can order
     *
     * @return array<string>
     */
    public function ordersAvailable(): array
    {
        //method that is Scope and start with Order
        $methods = array_filter(get_class_methods($this), [$this,'filterOrderScope']);
        //sub string that show name of order returned
        return array_map('getTypeOrderFromMethodName' , $methods);
    }

    /**
     * order query
     *
     * @param $q
     * @param string $type order type
     * @return Builder query that ordered
     */
    public function scopeOrdered($q,string $type): Builder
    {
        //method that is Scope and start with Order
        $methods = array_filter(get_class_methods($this), [$this,'filterOrderScope']);
        //check type exist in methods
        if (in_array($this->baseName . $type , $methods)){
            $finalNameMethod = lcfirst($this->nameScope) . ucfirst($type);
            return $q->$finalNameMethod();
        }else
            return $q;
    }




    private function filterOrderScope($methodName): bool
    {
        return str_starts_with($methodName, $this->baseName);
    }

    private function getTypeOrderFromMethodName($methodName): string
    {
        return substr($methodName , strlen($this->baseName) + 1);
    }



    /**
     * @return string
     */
    public function getNameScope(): string
    {
        return $this->nameScope;
    }

    /**
     * @param string $nameScope
     */
    public function setNameScope(string $nameScope): void
    {
        $this->nameScope = $nameScope;
    }

    /**
     * @return string
     */
    public function getBaseName(): string
    {
        return $this->baseName;
    }


}
