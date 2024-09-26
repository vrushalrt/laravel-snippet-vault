{{-- E-303 View Composer with blade --}}
<div class="container">

    {{-- user with most commented posts --}}
    <div class="row mt-2">
        <x-card :title="'Most Commented'" :subtitle="'What people are currently talking about.'" :items="$mostCommented" :isPosts="true" />
        {{-- card --}}                
    </div> {{-- row --}}

    {{-- user with most posts --}}
    <div class="row mt-3">
        <x-card :title="'Most Active'" :subtitle="'Users with most posts written.'" :items="$mostActive" :isUsers="true" />
        {{-- card --}}
    </div> {{-- row --}}

    {{-- most active user lastmonth --}}
    <div class="row mt-3">
        <x-card :title="'Most Active User Last Month'" :subtitle="'Users with most posts written in last month.'" :items="$mostActiveUserLastMonth" :isUsers="true" />
        {{-- card --}}
    </div> {{-- row --}}

</div> {{-- container --}}