<template>
    <div id="map" class="google-map" ref="googleMap"></div>
</template>

<script>
export default {
    props: {
        markers: {
            type: Array,
            default: null
        }
    },

    data () {
        return {
            map: null
        }
    },

    async mounted() {
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: import.meta.env.VITE_GOOGLE_MAP_API,
            v: "weekly",
        });

        this.initializeMap()

        // this.markers.map(marker => {
        //     new mapboxgl.Marker()
        //         .setLngLat([marker.longitude, marker.latitude])
        //         .setPopup(new mapboxgl.Popup().setHTML(marker.html))
        //         .addTo(map);
        // });

    },

    methods: {
        async initializeMap() {
            // The location of Uluru
            const position = { lat: 50.5000386, lng: 3.8068281 };
            // Request needed libraries.
            //@ts-ignore
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            const map = new Map(document.getElementById("map"), {
                zoom: 9,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            this.markers.map(marker => {
                new AdvancedMarkerElement({
                    position: { lat: parseFloat(marker.latitude), lng: parseFloat(marker.longitude) },
                    map: map,
                    title: marker.html
                });
            });

        }
    }

}

</script>

