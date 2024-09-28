---
layout: article
title: Empower Enums with Attributes
description: So I moved enum functions into attributes and it makes perfect sense to me.
publishAt: "2024-09-28"
ogImage: true
---

**Enum**, short for enumeration, means it's a list of values that can represent whatever you want in your application. This was added to PHP in 8.1 (2021). I've used enums since it was released and the teams I've worked with have also been using it. Nowadays most projects use it already.

I looked into all the repositories I've worked on in the last 3 years to see how enums were being used. Here are the common patterns I noticed.

## #1 Static functions are factories

Most static functions in enums are usually factories. Meaning it can create an instance of itself or sometimes a collection of itself.

```php
enum Parity{
    case Even;
    case Odd;

    public static function of($number): Parity{
        return $number % 2 == 0
            ? Parity::Even
            : Parity::Odd;
    }
}
```

```php
enum Letter{
    case A;
    case B;
    case C;
    case D;
    case E;

    /** @return array<Letter> */
    public static function vowels($number): array{
        return [Letter::A, Letter::E];
    }

    /** @return array<Letter> */
    public static function consonants($number): array{
        return [Letter::B, Letter::C, Letter::D];
    }
}
```

## #2 Mapper methods

These are the public methods that map a case in the enum to a defined value or logic. Examples of these are [label()]{.hl}, [color()]{.hl}, [description()]{.hl}, where all of these methods map a case to their label, color, or description. You'll know it's a mapper when you see [match]{.hl} or [switch]{.hl}.

```php
enum Status{
    case Pending;
    case Successful;
    case Failed;

    public function label(){
        return match($this){
            Status::Pending => "Order Pending",
            Status::Successful => "Order Successful",
            Status::Failed => "Order Failed",
        };
    }

    public function color(){
        return match($this){
            Status::Pending => "yellow",
            Status::Successful => "green",
            Status::Failed => "red",
        };
    }
}
```

## #3 Transformer or Generator methods

These are the public methods that use a case's value or name, either to transform it or to generate another value using it.

```php
enum Category : string{
    case Tech = "technologies";
    case Life = "life-stories";
    case Fun = "fun-activities";

    public function link(){
        return "https://mysite.com/articles/".$this->value;
    }

    public function heading(){
        return strtoupper($this->name);
    }

    public function imageGenerator(): ImageGenerator{
        $generator = $this->name."ImageGenerator";

        return new $generator;
    }
}
```

## #4 Stray methods

These are methods that are on the enum but don't belong there.🤪 We've all seen this and legend has it that tables have been broken because of this.

## Now what?

I recently reviewed a PR with an enum containing 20+ cases and a couple of mapper methods. You've probably seen something similar too, like a [Country]{.hl} enum. It holds a ton of cases and has multiple mapper methods like [code()]{.hl} and [currency()]{.hl}. Imagine looking up the country code and currency of a single country, you'll be scrolling up and down a long list of repeated cases, right?

So this got me thinking, wouldn't it be nice if an enum looks like a restaurant menu, it's an enumeration of food choices but all relevant information is blocked together. In the same block you see the name, description, price and category. You don't need to scroll down or go to another page to check out the price or description of the item. I think enums should be like this too, it would make it easier to read and maintain.

Luckily, PHP 8.0 introduced [Attributes]{.hl}. This is the perfect solution for what I'm trying to accomplish, and it's the perfect name too. Aren't price, category, and description all just attributes of a food selection in a menu? So I used attributes on my enums and this is how it looks now. Every relevant information are all blocked together.

```php
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Code{
    public function __construct(
        public string $code
    ){}
}

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Currency{
    public function __construct(
        public string $currency
    ){}
}

enum Country{
    #[Code("PH")]
    #[Currency("PHP")]
    case Philippines;

    #[Code("AU")]
    #[Currency("AUD")]
    case Australia;

    #[Code("US")]
    #[Currency("USD")]
    case UnitedStates;
}
```

Now to access them we'll have to use reflection.

```php
enum Country{
    // cases...

    public function code(){
        $ref = new ReflectionEnumBackedCase($this::class, $this->name);

        $attributes = $ref->getAttributes(Code::class);

        if($attributes === []){
            throw new Exception("Attribute is not defined on this case.");
        }

        return $attributes[0]->newInstance()->code;
    }

    public function currency(){
        $ref = new ReflectionEnumBackedCase($this::class, $this->name);

        $attributes = $ref->getAttributes(Currency::class);

        if($attributes === []){
            throw new Exception("Attribute is not defined on this case.");
        }

        return $attributes[0]->newInstance()->currency;
    }
}
```

You're probably looking at that block of code and feel like this is extra work for too little value. Well, yes and no.
Yes if you only have a few cases and dealing with very simple mappings. No if you have a lot of cases and more complex mappings. Also no, if you can just make this entire process simple. Which is what I did on this package [princejohnsantillan/reflect](https://github.com/princejohnsantillan/reflect){.hl}.

Using the package this is what it'll look like.

```php
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Price{
    use HasEnumTarget;

    public function __construct(
        public int $price
    ){}
}

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Color{
    use HasEnumTarget;

    public function __construct(
        public string $color
    ){}
}

enum Plan: string{
    #[Price(0)]
    #[Color('green')]
    case FREE = 'free';

    #[Price(50)]
    #[Color('blue')]
    case PRO = 'professional';

    #[Price(200)]
    #[Color('gold')]
    case ENTERPRISE = 'enterprise';

    public function price(): int {
        // Demonstrating usage via the Reflect class
        return Reflect::on($this)
            ->getAttributeInstance(Price::class)
            ->price;
    }

    public function color(): string {
        // Demonstrating usage via the HasEnumTarget trait
        return Color::onEnum($this)->color;
    }
}
```

Technically you can already remove the methods from your enum and access it via the attribute. Which kinda reads good too.

```php
// Get the color attribute on the Free Plan.
Color::onEnum(Plan::Free)->color;
```

Do note that attributes are now reusable too. And since they are now objects you can add more functionality to them too. Color for example can have a method for converting to RGB and another for Hexadecimal.

So there you go! We have now **[Empowered our Enums with Attributes]{.hl}**! I hope you found this useful. Let me know what you think. I'm looking to connect with more PHP/Laravel developers, connect with me on [x.com/pjsantillan](https://x.com/pjsantillan).
