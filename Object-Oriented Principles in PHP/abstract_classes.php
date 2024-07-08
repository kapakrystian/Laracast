<?php


//nie ma możliwości tworzenia instancji klas abstrakcyjnych
abstract class AchievementType
{
    public function name()
    {
        $class = (new ReflectionClass($this))->getShortName();

        return trim(preg_replace('/[A-Z]/', ' $0', $class));
    }

    public function icon()
    {
        return strtolower(str_replace(' ', '-', $this->name())) . '.png';
    }

    abstract public function qualifier($user);
}

// metoda abstrakcyjna wymaga definicji wewnątrz klas dziedziczących


class FirstThousandPoints extends AchievementType
{
    public function qualifier($user)
    {
    }
}


class FirstBestAnswear extends AchievementType
{
    public function qualifier($user)
    {
    }
}


echo $e = (new FirstBestAnswear)->qualifier('eeee');
