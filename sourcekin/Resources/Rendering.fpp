namespace Sourcekin\Components\Rendering\Model {
    data Name        = String deriving (FromString, ToString, Equals);
    data Attribute   = Attribute { Name $name, string $content } deriving(FromArray, ToArray, Equals);
    data Field       = Field { Name $name, string $content } deriving (FromArray,ToArray, Equals);
    data ContentId   = String deriving (FromString, ToString, Equals);

}
