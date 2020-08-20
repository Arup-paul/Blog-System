export default {

    methods:{
        makeParagraph(obj){
            return `<p class="blog_post_text">
                ${obj.data.text}
        </p>`
        },
        makeImage(obj){
            const caption = obj.data.caption ? `<div class="blog_caption">
                    <p>${obj.data.caption}</p>
            </div>` : ''
              return `<div class="blog_image">
                <img src="${obj.data.file.url}" alt="${obj.data.caption}"/>
                ${caption} `
        },
        makeEmbed(obj){

        },
        makeHeader(obj){
            return `<h${obj.data.level} class="blog_post_h${obj.data.level}">${obj.data.text}</h${obj.data.level}>`
        },
        makeCode(obj){

        },
        makeList(obj){
            if(obj.data.style === 'unordered'){
                const list = obj.data.items.map(item => {
                return `<li>${item}</li>`;
                });

                return `<ul clas="blog_post_ul">
                   ${list.join('')}
                </ul>`;
            }else{
                const list = obj.data.items.map(item => {
                    return `<li>${item}</li>`;
                    });
    
                    return `<ul clas="blog_post_ul">
                       ${list.join('')}
                    </ul>`; 
            }
        },
        makeQuote(obj){

        },

    }
}