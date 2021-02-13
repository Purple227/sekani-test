
@extends('layouts.app')

@section('title')

{{ " Excel data grabber " }}

@endsection

@section('content')


<div class="container"> <!-- parent tag open -->

	<div class="pageloader bg-orange" v-bind:class="{ 'is-active': loader.page }"><span class="title"> Excel data grabber </span></div>

	<div class="columns"> <!-- Columns wrapper tag open -->


		<div class="column"> <!-- First column tag open -->

			<div class="notification bg-light-orange" v-if="excel.error">
				<button class="delete" @click="excel.error = null"></button>
				@{{ excel.error }}
			</div>

			<div class="notification bg-light-orange" v-if="excel.status">
				<button class="delete" @click="excel.status = null"></button>
				Task succesfull
			</div>

			<div class="field">
				<div class="file has-name">
					<label class="file-label">
						<input class="file-input is-info" type="file"  @change="fileUpload">
						<span class="file-cta">
							<span class="file-icon">
								<i class="fas fa-file light-orange"></i>
							</span>
							<span class="file-label is-bold">
								Choose a file…
							</span>
						</span>
						<span class="file-name">
							@{{  excel.name || "Upload a file" }}
						</span>
					</label>
				</div>
			</div>



			<div class="field">
				<div class="field-body">
					<div class="field is-grouped">
						<div class="control">
							<button type="submit" class="button bg-orange is-bold has-text-white" v-bind:class="{ 'is-loading': loader.button }" @click="getExcelData"> Save </button>
						</div>
					</div>
				</div>
			</div>



		</div> <!-- First column tag close -->








		<div class="column"> <!-- Second column tag open -->

@verbatim

			<!-- Search input section -->
			<div class="field has-addons has-addons-centered" v-if="clientData != null">
				<div class="control has-icons-left is-expanded">
					<input class="input" type="text" placeholder="Search Client By Acc No" v-model="searchQuery" v-on:keyup="searchClient">
					<span class="icon is-small is-left">
						<i class="fas fa-search orange"></i>
					</span>
				</div>
			</div>

<div class="table-container" v-if="clientData != null">

			<table class="table is-bordered is-striped is-hoverable" > <!-- Table tag open -->

				<thead>
					<tr>
						<th> <span class="orange"> ID </span> </th>
						<th> <span class="orange"> First Name </span> </th>
						<th> <span class="orange"> Last Name </span> </th>
						<th> <span class="orange"> Branch  </span> </th>
						<th> <span class="orange"> Account No. </span> </th>
						<th> <span class="orange"> Account Type </span> </th>
						<th> <span class="orange"> Account Balance </span> </th>
					</tr>
				</thead>

				<tbody>

					<tr v-for="(client, index) in searchQuery.length  > 1  ? searchResult : clientData " :key="index">
						<th> <span class="orange">  {{ index +1  }}  </span> </th>
						<td> {{ client.first_name }} </td>
						<td>   {{ client.last_name }} </td>
						<td> {{ client.branch }} </td>
						<td> {{ client.account_no }} </td>
						<td> {{ client.account_type }} </td>
						<td> {{ client.account_balance }} </td>
					</tr>

				</tbody>

			</table> <!-- Table tag close -->

</div>

      <!-- Pagination section -->
      <div class="buttons has-addons is-centered" v-if="clientData != null">
        <a class="button" v-if="clientPagination.previousPageUrl" v-bind:class="{ 'is-loading': clientPagination.loader }" @click="getClientData(clientPagination.previousPageUrl)">
          <span class="icon is-small">
            <i class="fas fa-arrow-left orange"></i>
          </span>
          <span> Previous </span>
        </a>

        <a class="button">

          {{ clientPagination.to}} 0f {{ clientPagination.total }}
        </a>

        <a class="button" v-if="clientPagination.nextPageUrl" v-bind:class="{ 'is-loading': clientPagination.loader }" @click="getClientData(clientPagination.nextPageUrl)">
          <span class="icon is-small">
            <i class="fas fa-arrow-right orange"></i>
          </span>
          <span> Next </span>
        </a>
      </div>




			<div class="card" v-else>
				<div class="card-content">
					<div class="content is-bold has-text-centered subtitle">
						<span class="fa"> No data found </span>
					</div>
				</div>
			</div>

@endverbatim

		</div> <!-- Second column tag close -->






	</div> <!-- Columns wrapper tag close -->














</div> <!-- Parent tag close -->



@endsection