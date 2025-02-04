@php
    $price = (!empty($instructor->meeting)) ? $instructor->meeting->amount : 0;
    $discount = (!empty($price) and !empty($instructor->meeting) and !empty($instructor->meeting->discount) and $instructor->meeting->discount > 0) ? $instructor->meeting->discount : 0;
@endphp

<a href="{{ $instructor->getProfileUrl() }}" class="">
    <div class="position-relative d-flex flex-wrap instructor-finder-card border border-gray300 rounded-sm py-25 mt-20">

        <div class="col-12 col-md-8 d-flex">
            <div class="instructor-avatar rounded-circle">
                <img src="{{ $instructor->getAvatar(70) }}" class="img-cover rounded-circle" alt="{{ $instructor->full_name }}">
            </div>

            <div class="ml-20">
                <h3 class="font-16 font-weight-bold text-secondary">{{ $instructor->full_name }}</h3>

                <div>
                    <span class="d-block font-12 text-gray">{{ $instructor->bio }}</span>

                    @if(!empty($instructor->occupations))
                        <div class="d-block font-14 text-gray mt-5">
                            @foreach($instructor->occupations as $occupation)
                                @if(!empty($occupation->category))
                                    <span>{{ $occupation->category->title }}{{ !($loop->last) ? ', ' : '' }}</span>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <p class="font-14 text-gray mt-10">{{ truncate($instructor->about, 200) }}</p>
            </div>
        </div>

        <div class="col-12 col-md-4 mt-10 mt-md-0 pt-10 pt-md-0 instructor-finder-card-right-side position-relative">
            @if(!empty($discount))
                <span class="off-badge badge badge-danger">{{ trans('public.offer',['off' => $discount]) }}</span>
            @endif

            <div class="d-flex align-items-start">
                 <div class="d-flex flex-column">
                            <span class="font-16 font-weight-bold text-primary">Avaliação média</span>
                </div>
                       

                    
            </div>

            @include('web.default.includes.webinar.rate',['rate' => $instructor->rates()])



            <div class="d-flex align-items-center mt-25">
                @foreach($instructor->getBadges() as $badge)
                    <div class="mr-15 instructor-badge rounded-circle" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{!! (!empty($badge->badge_id) ? nl2br($badge->badge->description) : nl2br($badge->description)) !!}">
                        <img src="{{ !empty($badge->badge_id) ? $badge->badge->image : $badge->image }}" class="img-cover rounded-circle" alt="{{ !empty($badge->badge_id) ? $badge->badge->title : $badge->title }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</a>
