@extends('front.cleaning.layout')

@section('pagename')
 - {{__('Team Members')}}
@endsection

@section('meta-keywords', "$be->team_meta_keywords")
@section('meta-description', "$be->team_meta_description")

@section('breadcrumb-title', convertUtf8($bs->team_title))
@section('breadcrumb-subtitle', $bs->team_subtitle)
@section('breadcrumb-link', __('Team Members'))

@section('content')
    <!-- Start finlance_team section -->
    <section class="finlance_team team_v1 gray_bg pt-115 pb-80">
        <div class="container">
            <div class="team-carousel-active">
                <div class="row">
                    @foreach ($members as $key => $member)
                        <div class="col-lg-4 col-md-6 mb-5">
                            <div class="single-team-item mx-0">
                                <img class="lazy" data-src="{{asset('assets/front/img/members/'.$member->image)}}" alt="">
                                <div class="single-team-content">
                                    <div class="single-team-member-details">
                                        <h4>{{convertUtf8($member->name)}}</h4>
                                        <p>{{convertUtf8($member->rank)}}</p>
                                    </div>
                                    <ul class="team-social-links">
                                        @if (!empty($member->facebook))
                                            <li><a href="{{$member->facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                        @endif
                                        @if (!empty($member->twitter))
                                            <li><a href="{{$member->twitter}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        @endif
                                        @if (!empty($member->linkedin))
                                            <li><a href="{{$member->linkedin}}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                        @endif
                                        @if (!empty($member->instagram))
                                            <li><a href="{{$member->instagram}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End finlance_team section -->
@endsection
