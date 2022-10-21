<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
		<div class="container">
			<a class="navbar-brand"><h1>{{msg}}</h1></a>
			<div class="navbar-nav">
				<ul class="nav-item">
					<li class="nav-link">
						<router-link :to="{name : postList}">Post</router-link>
					</li>
					<li class="nav-link">
						<router-link>Category</router-link>
					</li>
					<li class="nav-link">
						<router-link></router-link>
					</li>
				</ul>
			</div>
		</div>
	</nav>
  </div>
</template>

<script>
export default {
  name: 'layout',
  props: {
    msg: String
  }
}
</script>
