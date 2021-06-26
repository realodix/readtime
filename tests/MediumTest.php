<?php

namespace Realodix\ReadTime\Test;

use Realodix\ReadTime\ReadTime;

class MediumTest extends TestCase
{
    /**
     * Articles taken directly from Medium, ReadTime must output the exact same as Medium,
     * which is 9 min read.
     *
     * Reference
     * - https://medium.com/@dahul/inside-medium-94931f66eebd
     * - https://blog.medium.com/read-time-and-you-bc2048ab620c
     *
     * @test
     */
    public function articleWithManyImages()
    {
        $wordSpeed = 265;

        $content = str_repeat('<img src="image.jpg">', 140).
        'Last month I spent the day at Medium’s San Francisco office. This was part of a personal project
        called 140 Portraits. The project is a behind the scene look at a person or business documented
        throughout one day in 140 images.
        April 29th | 8:30am I arrived @Medium 760 Market St, San Francisco. 9th floor of the historic Phelan
        Building.
        A big thank you to all the fine folks at Medium. It was an honor to spend the day with you. To have a
        look at other 140 projects: Inside NerdWallet or Gary Vaynerchuk Connect up with me on Instagram:
        @dahul';
        $this->assertSame('9 min read', (new ReadTime($content, $wordSpeed))->get());
    }

    /**
     * Articles taken directly from Medium, ReadTime must output the exact same as Medium,
     * which is 5 min read.
     *
     * Reference
     * - https://medium.com/@fchimero/this-should-only-take-a-minute-or-four-probably-e38bb7bf2adf
     * - https://blog.medium.com/read-time-and-you-bc2048ab620c
     *
     * @test
     */
    public function complexityOfAnArticle()
    {
        $wordSpeed = 265;

        $content =
        '<article><section class="es et eu ev w ew bu s"></section><span style="display: block; position: absolute; left: 788.475px; top: 5306.52px; height: 153px; width: 0px;"><span class="s li" aria-hidden="true"></span></span><div><div class="fd ei ue ff fg fh"></div><div class="eu ev ew ao"><div class="s h g f e"><aside class="uq fd em" style="width: 162.5px;"><div class="vk ly fd xl vm w"><p class="ba b mz bc by"><span class="bv ly vm lj nb">Top highlight</span></p></div></aside></div></div><section class="dm fi fj dh fk"><div><div class="fl fm fn fo fp w fq fr fs ft fu fv fw fx fy"><div class="fz ga gb"><div class="n p"><div class="ap aq ar as at gc av w"><div class=""><h1 id="title" class="gd dk ge ba cz gf gg gh gi gj gk gl gm gn go gp gq gr gs gt gu gv gw gx gy gz ha">This Should Only Take a Minute or Four, Probably</h1></div><div class=""><h2 id="subtitle" class="hb dk ge ba b hc hd he hf hg hh hi hj hk hl hm hn ho hp hq hr hs">Time Point Management for Literates</h2><div class="cw"><div class="n cj ht hu hv"><div class="o n"><div><a rel="noopener" href="/@fchimero?source=post_page-----e38bb7bf2adf--------------------------------"><img alt="Frank Chimero" class="s hw hx hy" src="https://miro.medium.com/fit/c/56/56/0*3vp3cwFhuTSH4auI.jpeg" width="28" height="28"></a></div><div class="dy w n ct"><div class="n"><div style="flex:1"><span class="ba b bb bc ha"><div><div class="bv" role="tooltip" aria-hidden="false" aria-describedby="3" aria-labelledby="3"><a class="" rel="noopener" href="/@fchimero?source=post_page-----e38bb7bf2adf--------------------------------"><p class="ba b bb bc ha">Frank Chimero</p></a></div></div></span></div></div><span class="ba b bb bc hs"><a class="" rel="noopener" href="/@fchimero/this-should-only-take-a-minute-or-four-probably-e38bb7bf2adf?source=post_page-----e38bb7bf2adf--------------------------------"><p class="ba b bb bc hs"><span class="hz"></span>Jun 1, 2014<span class="ia">·</span>5 min read</p></a></span></div></div><div class="n cs ib ic id ie if ig ih ii"><div class="n o"><div class="ij s"><div class="bv" aria-hidden="false" aria-describedby="postFooterSocialMenu" aria-labelledby="postFooterSocialMenu"><div><div class="bv" role="tooltip" aria-hidden="false" aria-describedby="1" aria-labelledby="1"><button class="ds dt bz ca cb cc cd ce cf bl il im cg in io" aria-controls="postFooterSocialMenu" aria-expanded="false" aria-label="Share Post"><svg width="25" height="25" class="ik"><g fill-rule="evenodd"><path d="M15.6 5a.42.42 0 0 0 .17-.3.42.42 0 0 0-.12-.33l-2.8-2.79a.5.5 0 0 0-.7 0l-2.8 2.8a.4.4 0 0 0-.1.32c0 .12.07.23.16.3h.02a.45.45 0 0 0 .57-.04l2-2V10c0 .28.23.5.5.5s.5-.22.5-.5V2.93l2.02 2.02c.08.07.18.12.3.13.11.01.21-.02.3-.08v.01"></path><path d="M18 7h-1.5a.5.5 0 0 0 0 1h1.6c.5 0 .9.4.9.9v10.2c0 .5-.4.9-.9.9H6.9a.9.9 0 0 1-.9-.9V8.9c0-.5.4-.9.9-.9h1.6a.5.5 0 0 0 .35-.15A.5.5 0 0 0 9 7.5a.5.5 0 0 0-.15-.35A.5.5 0 0 0 8.5 7H7a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h11a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"></path></g></svg></button></div></div></div></div><div class="ip s"><div class="vs"><span><a class="ds dt bz ca cb cc cd ce cf bl il im cg in io" rel="noopener" href="/m/signin?actionUrl=https%3A%2F%2Fmedium.com%2F_%2Fbookmark%2Fp%2Fe38bb7bf2adf&amp;operation=register&amp;redirect=https%3A%2F%2Fmedium.com%2F%40fchimero%2Fthis-should-only-take-a-minute-or-four-probably-e38bb7bf2adf&amp;source=post_actions_header--------------------------bookmark_preview-----------"><svg width="25" height="25" viewBox="0 0 25 25"><path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path></svg></a></span></div></div><div class="s ay"></div></div></div></div></div></div></div></div></div></div></div></section><section class="dm fi fj dh fk"><div class="n p"><div class="ap aq ar as at gc av w"><p id="252c" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">If you read things on the internet (like you are doing right now) maybe you’ve noticed the addition of time points to many sites. They’re right here on Medium, too. Here are a few examples:</p><ul class=""><li id="7abd" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl jn jo jp jm" data-selectable-paragraph="">The Astonishing, Disappointing iPad: 4 min read</li><li id="e5c2" class="iq ir ge is b hc jq iu iv hf jr ix iy iz js jb jc jd jt jf jg jh ju jj jk jl jn jo jp jm" data-selectable-paragraph="">Dear Guy Who Just Made My Burrito: 4 min read</li><li id="28d8" class="iq ir ge is b hc jq iu iv hf jr ix iy iz js jb jc jd jt jf jg jh ju jj jk jl jn jo jp jm" data-selectable-paragraph="">Jesus is Destroying Civilization: 1 min read</li></ul><p id="e754" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">There are also videos which tell you how long they take to watch.</p><ul class=""><li id="6aa7" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl jn jo jp jm" data-selectable-paragraph="">Screaming Goats: 2 min</li><li id="d830" class="iq ir ge is b hc jq iu iv hf jr ix iy iz js jb jc jd jt jf jg jh ju jj jk jl jn jo jp jm" data-selectable-paragraph="">Useless Fact That Will Melt Your Mind: 2 min</li><li id="57ed" class="iq ir ge is b hc jq iu iv hf jr ix iy iz js jb jc jd jt jf jg jh ju jj jk jl jn jo jp jm" data-selectable-paragraph="">Watch 27 Dogs Wreak Absolute Havoc In Under 90 Seconds: 92 seconds</li></ul><blockquote class="jv"><p id="fd55" class="jw jx ge ba jy jz ka kb kc kd ke jl by" data-selectable-paragraph="">Free time is very important, but so is consuming content, and the tension between the two requires timeonomics.</p></blockquote></div></div></section><div class="n p cw kf kg kh" role="separator"><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk"></span></div><section class="dm fi fj dh fk"><div class="n p"><div class="ap aq ar as at gc av w"><p id="6163" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">If you live in a developed nation, your average life<span id="rmm"> </span>span is about 80 years. Most children learn to read at 5 years-old, so we only have about 39.5 million life points to invest in consuming content. Of course, this presumes you do not sleep, and instead lay in bed for eight hours each night, flicking through shit on your phone.</p><blockquote class="jv"><p id="a1e8" class="jw jx ge ba jy jz km kn ko kp kq jl by" data-selectable-paragraph="">I’m thirty now. Only 26 million life points left. How will I use them?</p></blockquote></div></div></section><div class="n p cw kf kg kh" role="separator"><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk"></span></div><section class="dm fi fj dh fk"><div class="n p"><div class="ap aq ar as at gc av w"><p id="528f" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">Songs and videos have time baked in, so you can easily translate them into time points. Written stuff is more difficult. Who knows how long it takes to read something? Ah! The mathematics people do. You can use this equation to convert words into time points:</p><blockquote class="jv"><p id="a329" class="jw jx ge ba jy jz km kn ko kp kq jl by" data-selectable-paragraph="">T = Number of words in text ÷ average reading speed in words per minute</p></blockquote><p id="6e66" class="iq ir ge is b hc kr iu iv hf ks ix iy iz kt jb jc jd ku jf jg jh kv jj jk jl dm jm" data-selectable-paragraph="">I’ve modified the covers of a few seminal texts to include time point data.</p><figure class="kx ky kz la lb lc eu ev paragraph-image"><div role="button" tabindex="0" class="ld le ao lf w lg"><div class="eu ev kw"><div class="lm s ao ln"><div class="lo lp s"><div class="ej lh fd em ei li w lj lk ll"><img alt="" class="fd em ei li w lq lr af vz" src="https://miro.medium.com/max/60/1*vAJkT5nOyZV_EjPrVlLbag.jpeg?q=20" role="presentation" width="1000" height="493"></div><img alt="" class="oi uf fd em ei li w c" role="presentation" src="https://miro.medium.com/max/1000/1*vAJkT5nOyZV_EjPrVlLbag.jpeg" srcset="https://miro.medium.com/max/276/1*vAJkT5nOyZV_EjPrVlLbag.jpeg 276w, https://miro.medium.com/max/552/1*vAJkT5nOyZV_EjPrVlLbag.jpeg 552w, https://miro.medium.com/max/640/1*vAJkT5nOyZV_EjPrVlLbag.jpeg 640w, https://miro.medium.com/max/700/1*vAJkT5nOyZV_EjPrVlLbag.jpeg 700w" sizes="700px" width="1000" height="493"><noscript><img alt="" class="fd em ei li w" src="https://miro.medium.com/max/2000/1*vAJkT5nOyZV_EjPrVlLbag.jpeg" width="1000" height="493" srcSet="https://miro.medium.com/max/552/1*vAJkT5nOyZV_EjPrVlLbag.jpeg 276w, https://miro.medium.com/max/1104/1*vAJkT5nOyZV_EjPrVlLbag.jpeg 552w, https://miro.medium.com/max/1280/1*vAJkT5nOyZV_EjPrVlLbag.jpeg 640w, https://miro.medium.com/max/1400/1*vAJkT5nOyZV_EjPrVlLbag.jpeg 700w" sizes="700px" role="presentation"/></noscript></div></div></div></div><figcaption class="lt lu ew eu ev lv lw ba b bb bc by" data-selectable-paragraph="">Reconsidering Classic Texts to be more suitable for timeonomics.</figcaption></figure></div></div></section><div class="n p cw kf kg kh" role="separator"><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk"></span></div><section class="dm fi fj dh fk"><div class="n p"><div class="ap aq ar as at gc av w"><p id="0f8e" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">Of course, the formula breaks down with some writing. Some texts are very long and quite fluffy, like a Corgi dog. Other texts are short and very dense, like Danny DeVito.</p><figure class="kx ky kz la lb lc eu ev paragraph-image"><div class="eu ev lx"><img alt="" class="w ly lz" src="https://miro.medium.com/max/866/1*CeKw--n-3Haxsm5Vq3H9pw.jpeg" role="presentation" width="433" height="211"></div><figcaption class="lt lu ew eu ev lv lw ba b bb bc by" data-selectable-paragraph="">Some writing is like a Corgi, some writing is like a Danny DeVito. I’d like to think my Medium post is a bit of both. Just imagine that Corgi wearing those glasses, and you’ll get my point. See?</figcaption></figure><p id="2c90" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">Let me give you an example. Here is the beginning of the prologue to Tom Robbins’ <em class="ma">Still Life with Woodpecker. </em>A lot of people love this book, but I don’t really care for it that much, and now that I’ve set you up to enjoy it, here it is:</p><blockquote class="mb mc md"><p id="9fe0" class="iq ir ma is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">If this typewriter can’t do it, then fuck it, it can’t be done.</p><p id="dec8" class="iq ir ma is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">This is the all-new Remington SL3, the machine that answers the question, “Which is harder, trying to read <em class="ge">The Brothers Karamazov</em> while listening to Stevie Wonder records or hunting for Easter eggs on a typewriter keyboard?” This is the cherry on top of the cowgirl. The burger served by the genius waitress. The Empress card.</p><p id="0e5b" class="iq ir ma is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">I sense that the novel of my dreams is in the Remington SL3—although it writes much faster than I can spell. And no matter that my typing finger was pinched last week by a giant land crab. This baby speaks electric Shakespeare at the slightest provocation and will rap out a page and a half if you just look at it hard.</p></blockquote><p id="b7f9" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">OK, so the guy is excited about his typewriter, and a crab hurt him. But something about the tone strikes me wrong, as if Aaron Sorkin read a bunch of Bukowski and is now talking to himself. Anyway, this text is fluffy like a Corgi. It’s skimmable and snappy with bravado—just a neat little parade of disassociated references. I hate the word quirky, but this is quirky.</p><p id="f6a9" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">You get it.</p><blockquote class="jv"><p id="060a" class="jw jx ge ba jy jz km kn ko kp kq jl by" data-selectable-paragraph="">Our formula says that took 0.5 minutes to read.</p></blockquote></div></div></section><div class="n p cw kf kg kh" role="separator"><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk"></span></div><section class="dm fi fj dh fk"><div class="n p"><div class="ap aq ar as at gc av w"><p id="fbb4" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">Next, I’d like to show you a very short story by a writer named Lydia Davis. I’m quite fond of her work. This one is called “Head, Heart.” It is one of my favorite things.</p><blockquote class="mb mc md"><p id="9443" class="iq ir ma is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">Heart weeps.<br>Head tries to help heart.<br>Head tells heart how it is, again:<br>You will lose the ones you love. They will all go. But even the earth will go, someday.<br>Heart feels better, then.<br>But the words of head do not remain long in the ears of heart.<br>Heart is so new to this.<br>I want them back, says heart.<br>Head is all heart has.<br>Help, head. Help heart.</p></blockquote><blockquote class="jv"><p id="ae34" class="jw jx ge ba jy jz ka kb kc kd ke jl by" data-selectable-paragraph="">Oh My God.</p></blockquote><p id="9c81" class="iq ir ge is b hc kr iu iv hf ks ix iy iz kt jb jc jd ku jf jg jh kv jj jk jl dm jm" data-selectable-paragraph="">I mean, yeah, it’s emotional. But that’s okay, because it’s also eloquent and true.</p><p id="bff4" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">Our little formula says that this particular story by Davis should take 15 seconds to read. Maybe even less since it repeats the same words so often. <strong class="is cz">That estimate is wrong.</strong></p><p id="390c" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph=""><mark class="xk vj ns">Listen: you can’t tell, but between that story and this paragraph right here, two hours passed. I was splayed on the floor, prostrate with sadness, face-down and thinking about everyone I’ve lost. I’ve been carrying this story in my head for the past two years, reciting it over and over when I feel miserable and miss everyone who I’ve loved that has left this waking world.</mark></p><p id="1df0" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">So, if you factor in the exponential resonance, the multiplication of perpetual recitation, and the subtraction of loss, I think it’s taken me about a year and a half to read the 71 words in “Head, Heart.”</p></div></div></section><div class="n p cw kf kg kh" role="separator"><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk"></span></div><section class="dm fi fj dh fk"><div class="n p"><div class="ap aq ar as at gc av w"><p id="7c6c" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">I understand that there is too much to read, and I get that it is nice to know what a text expects from its reader. But it is shitty to come to a piece of writing without any generosity, and it is maybe just as bad to make design choices which produce that disposition.</p><p id="a684" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph="">When something has a price put on it, the price makes you stingy. A writer shouldn’t have to start at a deficit—writing is difficult enough—and a reader shouldn’t feel indulgent for spending more than 5 minutes with something. I think readers, writers, and writing deserve better.</p></div></div></section><div class="n p cw kf kg kh" role="separator"><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk kl"></span><span class="ki hw bv kj kk"></span></div><section class="dm fi fj dh fk"><div class="lc w"><figure class="kx ky kz la lb lc w paragraph-image"><img alt="" class="w ly lz" src="https://miro.medium.com/max/4800/1*LYkOrT_YG_kOPXDblTk_0Q.jpeg" role="presentation" width="2400" height="1000"></figure></div><div class="n p"><div class="ap aq ar as at gc av w"><p id="68f6" class="iq ir ge is b hc it iu iv hf iw ix iy iz ja jb jc jd je jf jg jh ji jj jk jl dm jm" data-selectable-paragraph=""></p></div></div></section></div></article>';
        $this->assertSame('5 min read', (new ReadTime($content, $wordSpeed))->get());
    }
}
