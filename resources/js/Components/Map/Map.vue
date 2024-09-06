<template>
    <div
        id="map"
        ref="googleMap"
        class="google-map"
    />
</template>

<script>
export default {
    props: {
        markers: {
            type: Array,
            default: null
        },
        canSetMarker: {
            type: Boolean,
            default: false
        }
    },

    emits: ['current-position'],

    data () {
        return {
            map: null,
            selectedMarker: null
        }
    },

    async mounted () {
        ((g) => { var h, a, k, p = 'The Google Maps JavaScript API', c = 'google', l = 'importLibrary', q = '__ib__', m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set(), e = new URLSearchParams(), u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement('script')); e.set('libraries', [...r] + ''); for (k in g)e.set(k.replace(/[A-Z]/g, t => '_' + t[0].toLowerCase()), g[k]); e.set('callback', c + '.maps.' + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + ' could not load.')); a.nonce = m.querySelector('script[nonce]')?.nonce || ''; m.head.append(a) })); d[l] ? console.warn(p + ' only loads once. Ignoring:', g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })({
            key: import.meta.env.VITE_GOOGLE_MAP_API,
            v: 'weekly'
        })

        this.initializeMap()
    },

    methods: {
        async initializeMap () {
            // The location of Uluru
            const position = { lat: 50.5000386, lng: 3.8068281 }
            // Request needed libraries.
            // @ts-ignore
            // eslint-disable-next-line no-undef
            const { Map } = await google.maps.importLibrary('maps')
            // eslint-disable-next-line no-undef
            const { AdvancedMarkerElement } = await google.maps.importLibrary('marker')

            // The map, centered at Uluru
            const map = new Map(document.getElementById('map'), {
                zoom: 9,
                center: position,
                mapId: 'DEMO_MAP_ID',
                controlSize: 33,

                fullscreenControl: false,
                streetViewControl: false
            })

            if (this.markers) {
                this.markers.map((marker) => {
                    new AdvancedMarkerElement({
                        position: { lat: parseFloat(marker.latitude), lng: parseFloat(marker.longitude) },
                        map: map,
                        title: marker.html
                    })
                })
            }

            this.addYourLocationButton(map)

            if (this.canSetMarker) {
                this.registerMapClick(map)
            }
        },

        addYourLocationButton (map) {
            const controlDiv = document.createElement('div')

            const firstChild = document.createElement('button')
            firstChild.style.backgroundColor = '#fff'
            firstChild.style.border = 'none'
            firstChild.style.outline = 'none'
            firstChild.style.width = '28px'
            firstChild.style.height = '28px'
            firstChild.style.borderRadius = '2px'
            firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)'
            firstChild.style.cursor = 'pointer'
            firstChild.style.marginRight = '10px'
            firstChild.style.padding = '0'
            firstChild.title = 'Your Location'
            controlDiv.appendChild(firstChild)

            const secondChild = document.createElement('div')
            secondChild.style.margin = '5px'
            secondChild.style.width = '18px'
            secondChild.style.height = '18px'
            secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-2x.png)'
            secondChild.style.backgroundSize = '180px 18px'
            secondChild.style.backgroundPosition = '0 0'
            secondChild.style.backgroundRepeat = 'no-repeat'
            firstChild.appendChild(secondChild)

            // eslint-disable-next-line no-undef
            google.maps.event.addListener(map, 'center_changed', function () {
                secondChild.style['background-position'] = '0 0'
            })

            const that = this

            firstChild.addEventListener('click', function () {
                let imgX = 0
                const animationInterval = setInterval(function () {
                    imgX = -imgX - 18
                    secondChild.style['background-position'] = imgX + 'px 0'
                }, 500)

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        // eslint-disable-next-line no-undef
                        const latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
                        map.panTo(latlng)
                        map.setZoom(15)

                        clearInterval(animationInterval)
                        secondChild.style['background-position'] = '-144px 0'
                        that.$emit('current-position', {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        })
                        if (that.canSetMarker) {
                            if (that.selectedMarker) {
                                that.selectedMarker.position = { lat: position.coords.latitude, lng: position.coords.longitude }
                            } else {
                                that.selectedMarker = new google.maps.marker.AdvancedMarkerElement({
                                    map: map,
                                    position: { lat: position.coords.latitude, lng: position.coords.longitude }
                                })
                            }
                        }
                    })
                } else {
                    clearInterval(animationInterval)
                    secondChild.style['background-position'] = '0 0'
                }
            })

            controlDiv.index = 1
            // eslint-disable-next-line no-undef
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv)
        },

        registerMapClick (map) {
            const that = this
            // eslint-disable-next-line no-undef
            google.maps.event.addListener(map, 'click', function (event) {
                if (that.selectedMarker) {
                    that.selectedMarker.position = event.latLng
                } else {
                    // eslint-disable-next-line no-undef
                    that.selectedMarker = new google.maps.marker.AdvancedMarkerElement({
                        map: map,
                        position: event.latLng
                    })
                }
                that.$emit('current-position', {
                    latitude: event.latLng.lat(),
                    longitude: event.latLng.lng()
                })
            })
        }
    }

}
</script>
