
@extends('layouts.app')
@section('title',$blog->title )
@push('css')

@endpush
@section('maincontent')

  

		<!-- BANNER -->
		<div class="blog_banner" style="background: url(/img/blog1.jpg) no-repeat center center;position: relative;min-height: 360px;z-index: 1;background-size: cover; padding: 100px 0px;">
			
		</div>
		<!-- BANNER -->
        
		<!-- BODY -->
		<div class="blog_post_sec_all">
			<div class="container">
				<div class="row">
					<div class="cl-12 col-md-12 col-lg-9">
						<div class="blog_post_left">
							<div class="blog_post_sec">
								<div class="blog_post_top">
                                  
                                     <ul class="blog_post_top_ul">
                                     @if(count($blog->cat) > 0)
                                          @foreach($blog->cat as $c)
												<li>
                                                  <a href="blog.html">  {{$c->categoryName}}</a>
												 </li>
                                            @endforeach
                                            @endif
                                            <li>1 Feb, 2020</li>
										 </ul>
									
								
                                </div>
                               
								<div class="blog_post">
									<h1 class="blog_post_h1">{{$blog->title}}</h1>
									<div class="post_author_sec">
										<div class="post_author_left">
											<div class="post_author_img">
												<img src="{{$blog->user->profilePic}}" alt="image">
											</div>
											<div class="post_author_info">
											<a href="contact_me.html"><h4 class="post_author_title">{{$blog->user->fullName}}</h4></a>
												<P>Arup is a full-stack developer skilled with PHP,Laravel,  Javascript, VUE JS and many other language</P>
											</div>
										</div>
										<div class="post_author_r8">
											<i class="fas fa-share-alt"></i>
										</div>
									</div>
									
									 {!!$blog->post!!}
									<div class="riview_post">
										<ul class="riview_post_ul">
											<li><i class="far fa-thumbs-up"></i>122 Like</li>
											<li><i class="far fa-comments"></i>10 Comment</li>
											<li><i class="far fa-share-square"></i>4 Share</li>
										</ul>
									</div>	
								</div>	
							</div>
							<div class="post_que">
								<h2 class="post_que_h2">UNDERSTANDING THE BASICS</h2>
								<!-- ITEAM -->
								<div class="post_que_single">
									<div class="post_que_single_top">
										<i class="fas fa-angle-right"></i>
										<p class="post_que_title">What is a chatbot and how does it work?</p>
									</div>
									<div class="post_que_single_btm dis_none">
										<p class="post_que_text">
											Chatbot terminology causes confusion. Chatbots are computer programs that respond to human messages. They are designed one of two ways: The first is based on rules that dictate the bot’s replies to specific commands. The second is with AI, where the goal is to comprehend the nuances of human language.
										</p>
									</div>
								</div>	
									<!-- ITEAM -->

									<!-- ITEAM -->
								<div class="post_que_single">
									<div class="post_que_single_top">
										<i class="fas fa-angle-right"></i>
										<p class="post_que_title">What are chatbots good for?</p>
									</div>
									<div class="post_que_single_btm dis_none">
										<p class="post_que_text">
											Some chatbots are designed to carry on casual conversations. Others act as customer service reps, providing deals, booking dates, and product support. There are also “digital assistants” that can do everything listed above while providing hundreds of extra features, like banking, home security, and traffic advice.
										</p>
									</div>
								</div>	
									<!-- ITEAM -->

									<!-- ITEAM -->
								<div class="post_que_single">
									<div class="post_que_single_top">
										<i class="fas fa-angle-right"></i>
										<p class="post_que_title">What are the types of chatbots?</p>
									</div>
									<div class="post_que_single_btm dis_none">
										<p class="post_que_text">
											Chatbot terminology causes confusion. Chatbots are computer programs that respond to human messages. They are designed one of two ways: The first is based on rules that dictate the bot’s replies to specific commands. The second is with AI, where the goal is to comprehend the nuances of human language.
										</p>
									</div>
								</div>	
									<!-- ITEAM -->
							</div>
						    <comment></comment>

							<!--WRITE COMMENT BOX -->
								<div class="cmnt_frm mar_t30">
									<h2 class="post_dtls_title2 pad_b20">Leave A Comment</h2>
								<div class="cmnt_frm_all">
									<div class="row">
										<div class="col-12 col-md-6 col-lg-6">
											<div class="cmnt_input">
												<p>NAME</p>
												<input type="text" placeholder="Enter your name">
											</div>
										</div>
										<div class="col-12 col-md-6 col-lg-6">
											<div class="cmnt_input">
												<p>E-MAIL</p>
												<input type="text" placeholder="Enter your E-MAIL">
											</div>
										</div>
										<div class="col-12 col-md-12 col-lg-12">
											<div class="cmnt_input">
												<p class="mar_b10">MESSAGE</p>
												<textarea placeholder="Type your comment" name="message" required=""></textarea>
											</div>
										</div>
										<div class="dtls_frm_btn mar_t20">
											<button class="btn1">send message</button>
										</div>
									</div>
								</div>
							</div>
							<!--WRITE COMMENT BOX -->
						</div>
                    </div>
                 
					<div class="col-12 col-md-12 col-lg-3">
						<div class="blog_post_r8">
								<h4 class="trnd_artcl_h4">TRENDING ARTICLES</h4>
							<div class="blog_post_r8_all">

                            
                                <!-- iteam -->
                                @if(count($relatedBlogs) > 0)
                                @foreach($relatedBlogs as $r)
								<div class="blog_post_r8_item">
									<div class="blog_post_item_lft">
										<img src="img/man3.jpg" alt="image">
									</div>
									<div class="blog_post_item_r8">
										<a href="/blog/{{$r->slug}}">
											<h4 class="blog_post_item_r8_h4">
												{{$r->title}}
											</h4>
										</a>
										<a href=""><p class="author_name2">-{{$r->user->fullName}}</p></a>
									</div>
                                </div>
                                @endforeach
                                @endif
								<!-- iteam -->

							

								
                            </div>

							<div class="course_price mar_t60">
								<div class="course_price_top">
									<p>Share this post</p>
								</div>
								<div class="course_price_main" style="padding: 30px 0px 30px 17px">
									<ul class="share_social_ul dis_flx">
										<li>
											<a class="fb" href="">
												<i class="fab fa-facebook-f"></i>
											</a>
										</li>
										<li>
											<a class="google" href="">
												<i class="fab fa-google-plus-g"></i>
											</a>
										</li>
										<li>
											<a class="instgrm" href="">
												<i class="fab fa-instagram"></i>
											</a>
										</li>
										<li>
											<a class="twtr" href="">
												<i class="fab fa-twitter"></i>
											</a>
										</li>
										<li>
											<a class="skpye" href="">
												<i class="fab fa-skype"></i>
											</a>
										</li>
										<li>
											<a class="utube" href="">
												<i class="fab fa-youtube"></i>
											</a>
										</li>
								<!-- 		<li>
											<a class="lnkdn" href="">
												<i class="fab fa-linkedin-in"></i>
											</a>
										</li>
										<li>
											<a class="pinstr" href="">
												<i class="fab fa-pinterest"></i>
											</a>
										</li> -->
									</ul>
								</div>
							</div>
							<div class="post_tags">
								<h3 class="post_tags_h3">Popular Tags</h3>
								<ul class="post_tags_ul">
                                    @if(count($blog->tag) > 0)
                                     @foreach($blog->tag as $t)
									<li>
										<a href="/tag/{{$t->tagName}}/{{$t->id}}">{{$t->tagName}}</a>
                                    </li>
                                    @endforeach
                                    @endif
									
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- BODY -->

@endsection